<?php
namespace App\Modules\Taxonomy\Logic;

use App\Modules\Client\Models\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Storage;
use Mtownsend\XmlToArray\XmlToArray;

class Taxonomy {
    private $disclosuresPath;
    private $disclosureArray;
    private $elements = array();
    private $elementId = 1;
    private $taxonomyData = [];
    private $definitionData = [];
    private $labelData = [];
    private $taxonomyElements = [];
    private $clientBuilder;
    private $roles;
    private $roleArray;
    private $roleID = '';


    public function __construct($disclosuresPath = null, $roles = null) {
        $this->clientBuilder = Clientbuilder::create()->build();
        $this->disclosuresPath = $disclosuresPath;
        $this->roles = $roles;
    }

    function indexRoles(){
        ini_set('max_execution_time', 0);
        foreach ($this->roles as $path) {
            if (file_exists($path)) {
                $xml = file_get_contents($path);
                $this->roleArray = XmlToArray::convert($xml);
                if (isset($this->roleArray['xs:annotation']['xs:appinfo']['link:roleType'])){
                    foreach ($this->roleArray['xs:annotation']['xs:appinfo']['link:roleType'] as $role){
                        $params = array();
                        $params['index'] = 'taxonomy_2019';
                        $params['type'] = 'element';
                        $params['id'] = (string)$role['@attributes']['id'];
                        $params['body'] = $this->prepareRoleProperties($role);

                        $this->clientBuilder->index($params);
                    }
                }

            }
        }
    }

    function prepareRoleProperties($role){
        $usedOn = [];
        if (is_array($role['link:usedOn'])){
            foreach ($role['link:usedOn'] as $used){
                $usedOn[] = $used;
            }
        } else {
            $used[] = $role['link:usedOn'];
        }


        return [
            'name' => $role['link:definition'],
            'roleURI' => $role['@attributes']['roleURI'],
            'parent_id' => ['0'],
            'usedOn' => $usedOn,
            'has_children' => false
        ];
    }

    function indexTaxonomyElements()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $this->getTaxonomyElementsAttributes();
        foreach ($this->taxonomyElements as $element){
            $params = array();
            $params['index'] = 'taxonomy_2019';
            $params['type'] = 'element';
            foreach ($element as $key => $attribute){
               $params['body'][$key] = $attribute;
            }
            $this->clientBuilder->index($params);
        }

        // here element trees are indexed/created
        foreach ($this->disclosuresPath as $path) {
            $this->elements = array();
            if (file_exists($path)) {
                $xml = file_get_contents($path);

                $this->disclosureArray = XmlToArray::convert($xml);
                $this->indexPresentationLinks();
            }
        }
    }

    function indexPresentationLinks(){
        if (!isset($this->disclosureArray['link:presentationLink']['link:loc'])){
            foreach ($this->disclosureArray['link:presentationLink'] as $presentationLink) {
                $roleURI = $presentationLink['@attributes']['role'];
                $this->setCurrentRoleId($roleURI);
                foreach ($presentationLink['link:loc'] as $item){
                    if (!isset($item['@attributes'])){
                        $this->prepareNewElement($item);
                    } else if (!empty($item)) {
                        $this->prepareNewElement($item);
                    }
                }
                foreach ($presentationLink['link:presentationArc'] as $item){
                    $preferredLabel = null;
                    if (!isset($item['@attributes'])){
                        if (isset($item['@attributes']['preferredLabel'])){
                            $preferredLabel = $item['@attributes']['preferredLabel'];
                        }
                        $elementId = $this->getElementIdByLabel($item['to']);
                        $parentId = $this->getElementIdByLabel($item['from']);
                        $this->updateElement($elementId, $parentId, $preferredLabel);
                    } else if (!empty($item)) {
                        if (isset($item['@attributes']['preferredLabel'])){
                            $preferredLabel = $item['@attributes']['preferredLabel'];
                        }
                        $elementId = $this->getElementIdByLabel($item['@attributes']['to']);
                        $parentId = $this->getElementIdByLabel($item['@attributes']['from']);
                        $this->updateElement($elementId, $parentId, $preferredLabel);
                    }
                }

                $tree = $this->buildTree($this->elements, $this->roleID);
                $this->updatePresentationRelations($tree);
                $this->elements = array();
            }
        } else {
            $roleURI = $this->disclosureArray['link:presentationLink']['@attributes']['role'];
            $this->setCurrentRoleId($roleURI);
            foreach ($this->disclosureArray['link:presentationLink']['link:loc'] as $item) {
                if (!empty($item)) {
                    $this->prepareNewElement($item);
                }
            }
            foreach ($this->disclosureArray['link:presentationLink']['link:presentationArc'] as $item) {
                $preferredLabel = null;
                if (!empty($item)) {
                    if (isset($item['@attributes']['preferredLabel'])){
                        $preferredLabel = $item['@attributes']['preferredLabel'];
                    }

                    $elementId = $this->getElementIdByLabel($item['@attributes']['to']);
                    $parentId = $this->getElementIdByLabel($item['@attributes']['from']);

                    $this->updateElement($elementId, $parentId, $preferredLabel);
                }
            }

            $tree = $this->buildTree($this->elements, $this->roleID);
            $this->updatePresentationRelations($tree);
            $this->elements = array();
        }
    }


    function array_reindex_recursive(&$array) {
        if(is_int(key($array))) {
            $array = array_values($array);
        }
        foreach($array as $key => &$val) {
            if ($key === 'parent_id' || $key === 'attributes' || $key === 'labels'){
                unset($array[$key]);
            }
            if(is_array($val)) {
                $this->array_reindex_recursive($val);
            }
        }
    }

    function updatePresentationRelations($tree){
        $this->array_reindex_recursive($tree);

        $elementData = $this->getElementDataByCode($tree[0]['code'], true);
        $tree[0]['label'] = $this->getLabel($elementData);
        $params = [
            'index' => 'taxonomy_2019',
            'id'    => $this->roleID,
            'body'  => [
                'doc' => [
                    'has_children' => true,
                    'tree' => json_encode($tree)
                ]
            ]
        ];

        $this->clientBuilder->update($params);
    }

    function setCurrentRoleId($role){
        $query = [
            "bool" => [
                "must" => [
                    [
                        "term" => [
                            "roleURI.keyword" => $role
                        ]
                    ]
                ]
            ]
        ];

        $taxonomyElement = ($this->clientBuilder->search([
            'index' => 'taxonomy_2019',
            'type' => 'element',
            'body' => [
                'size' => '1',
                'query' => $query
            ],
        ]));

        $this->roleID = $taxonomyElement['hits']['hits'][0]['_id'];
    }

    function prepareNewElement($item){
        $code = explode('_', $item['@attributes']['href'])[1];

        $this->elements[$this->elementId]['attributes']['code'] = $code;
        $this->elements[$this->elementId]['attributes']['label'] = $item['@attributes']['label'];
        $this->elements[$this->elementId]['attributes']['id'] = $this->elementId;
        $this->elementId++;
    }


    function getElementIdByLabel($label){
        foreach ($this->elements as $element){
            if ($element['attributes']['label'] == $label){
                return $element['attributes']['id'];
            }
        }
    }

    function updateElement($elementId, $parentId, $preferredLabel = null){
        $elementData = $this->getElementDataByCode($this->elements[$elementId]['attributes']['code'], true);

        $this->elements[$elementId]['parent_id'][] = $parentId;
        $this->elements[$elementId]['label'] = $this->getLabel($elementData, $preferredLabel);
        $this->elements[$elementId]['labels'][$parentId] = $this->getLabel($elementData, $preferredLabel);
    }

    function getLabel($element, $preferredLabel = null){
        if (isset($element['_source']['label'])){
            $labels = $element['_source']['label'];
        } else {
            return '';
        }

        if (is_null($preferredLabel)){
            $preferredLabel = 'http://www.xbrl.org/2003/role/label';
        }

        foreach ($labels as $label){
            if ($label['role'] == $preferredLabel)
                return $label['content'];
        }

        return 'Label not found!!!';
    }


    function buildTree(array &$elements, $parentId = 0) {
        $branch = array();
        foreach ($elements as $elementId => &$element) {
            if (!isset($element['parent_id'])) {
                $element['parent_id'][] = $this->roleID;
            }
            if (($key = array_search($parentId, $element['parent_id'])) !== false) {
                $element['code'] = $element['attributes']['code'];
                unset($element['parent_id'][$key]);
                if (isset($element['labels'])){
                    $element['label'] = $element['labels'][$parentId];
                }

                $children = $this->buildTree($elements, $elementId);
                if ($children) {
                    foreach ($children as $child){
                        $element[] = $child;
                    }
                }
                $branch[$elementId] = $element;
            }
        }
        return $branch;
    }

    public function getTaxonomyChildrenByParentId($parentId , $companyId){
        if($parentId === '0'){
            return $this->getRolesForPresentation();
        }
        $elements = [];
        $ids = explode('_', $parentId);
        $roleId = $ids[0];
        unset($ids[0]);

        $query = [
            "term" => [
                "_id" => $roleId
            ]
        ];

        $taxonomyElements = ($this->clientBuilder->search([
            'index' => 'taxonomy_2019',
            'type' => 'element',
            'body' => [
                'size' => '1000',
                'query' => $query,
            ],
        ]));

        $data = json_decode($taxonomyElements['hits']['hits'][0]['_source']['tree'], JSON_PRETTY_PRINT);
        if (!empty($ids)){
            $data = $this->getValueByKeyPositions($data, $ids);
        }

        foreach ($data as $key => $children){
            $hasChildren = false;
            if ($key !== 'code' && $key !== 'label'){
                if (count($children) > 2 && !isset($children['client_id'])){
                    $hasChildren = true;
                }

                if ($children['label'] == ""){
                    $children['label'] = $children['code'];
                }
                if (isset($children['client_id'])){
                    $elClientId = $children['client_id'];
                    $elCompanyId = $children['company_id'];

                    if ((int)$elClientId !== (int)Client::getCurrentClientId() || (int)$elCompanyId !== (int)$companyId){
                        continue;
                    }
                }
                $elements[] = [
                    'id' => $parentId . '_'. $key,
                    'code' => $children['code'],
                    'label' => $children['label'],
                    'has_children' => $hasChildren,
                ];
            }
        }

//        if (!is_null($companyId)){
//            $query['bool']['must'][] = $this->filterByCompany($companyId);
//        }

        return $elements;

        foreach ($taxonomyElements['hits']['hits'] as $el){
            $elements[] = [
                'id' => $el['_id'],
                'code' => $el['_source']['name'],
                'label' => $this->getDefaultLabel($el['_source']),
                'has_children' => true,
            ];
        }

        return $elements;
    }

    function getValueByKeyPositions($array, $keyPath) {
        foreach ($keyPath as $key) {
            $array = $array[$key];
        }
        return $array;
    }

    function getRolesForPresentation(){
        $elements = [];
        $query = [
            "bool" => [
                "must" => [
                    [
                        "terms" => [
                            "parent_id.keyword" => [0]
                        ]
                    ]
                ]
            ]
        ];

        $query['bool']['must'] = [
            [
                'term' => [
                    'usedOn.keyword' => 'link:presentationLink'
                ]
            ],
            [
                'term' => [
                    'has_children' => true
                ]
            ]
        ];

        $sort = [
            "name.keyword" => [
                "order" => "asc"
            ]
        ];

        $taxonomyElements = ($this->clientBuilder->search([
            'index' => 'taxonomy_2019',
            'type' => 'element',
            'body' => [
                'size' => '1000',
                'query' => $query,
                'sort' => $sort
            ],
        ]));

        foreach ($taxonomyElements['hits']['hits'] as $el){
            $elements[] = [
                'id' => $el['_id'],
                'label' => $el['_source']['name'],
                'has_children' => true,
            ];
        }

        return $elements;
    }

    function getDefaultLabel($element){
        $labels = $element['label'];
        $preferredLabel = 'http://www.xbrl.org/2003/role/label';
        if ($element['preferredLabel'] !== ''){
            $preferredLabel = $element['preferredLabel'];
        }

        if(is_array($labels)){
            foreach ($labels as $label){
                if($label['role'] === $preferredLabel){
                    return $label['content'];
                }
            }
        }

        return 'Label not found';
    }

    public function getTaxonomyElementsAttributes(){
        $this->getTaxonomyFilesData();
        foreach ($this->taxonomyData as $item) {
            if (!empty($item)) {
                $targetNamespace = null;
                if (isset($item['@attributes']) && isset($item['@attributes']['targetNamespace'])){
                    $targetNamespace = $item['@attributes']['targetNamespace'];
                }

                foreach ($item['xs:element'] as $element) {
                    foreach ($element as $key => $attributes) {
                        $attributes['code'] = $attributes['id'];
                        $attributes['namespace'] = $targetNamespace;
                        $this->taxonomyElements[$attributes['name']] = $attributes;
                    }
                }
            }
        }

        $this->addElementsDefinition();
        $this->addElementsLabel();

    }

    public function addElementsDefinition(){
        $this->getDefinitionData();
        foreach ($this->definitionData as $data){
            foreach ($data['link:labelLink']['link:label'] as $definitionDatum) {
                $content = $definitionDatum['@content'];
                if (isset($definitionDatum['@attributes']) && isset($definitionDatum['@attributes']['label'])){
                    $label = $definitionDatum['@attributes']['label'];
                    $name = explode('_', $label)[1];
                    $this->taxonomyElements[$name]['documentation'] = $content;
                }
            }
        }
    }

    public function addElementsLabel() {
        $this->getLabelData();
        foreach ($this->labelData as $data) {
            foreach ($data['link:labelLink']['link:label'] as $definitionDatum) {
                $content = $definitionDatum['@content'];
                $role = $definitionDatum['@attributes']['role'];
                if (isset($definitionDatum['@attributes']) && isset($definitionDatum['@attributes']['label'])) {
                    $label = $definitionDatum['@attributes']['label'];
                    $name = explode('_', $label)[1];
                    $this->taxonomyElements[$name]['label'][] =
                        [
                            'content' => $content,
                            'role' => $role
                        ];
                }
            }
        }
    }

// taxonomy files start here
    public function getTaxonomyFilesData($year = 2019){
        $taxFile = Storage::disk('taxonomy')->get($year . '/srt-' . $year . '-01-31.xsd');
        $this->taxonomyData[] = XmlToArray::convert($taxFile);

        $taxFile = Storage::disk('taxonomy')->get($year . '/us-gaap-' . $year . '-01-31.xsd');
        $this->taxonomyData[] = XmlToArray::convert($taxFile);

        $taxFile = Storage::disk('taxonomy')->get($year . '/dei-' . $year . '-01-31.xsd');
        $this->taxonomyData[] = XmlToArray::convert($taxFile);

        $investFilePath = storage_path('app/taxonomy/').$year.'/invest-2013-01-31.xsd';
        if (file_exists($investFilePath)){
            $taxFile = Storage::disk('taxonomy')->get($year . '/invest-2013-01-31.xsd');
            $this->taxonomyData[] = XmlToArray::convert($taxFile);
        }
        $countryFilePath = storage_path('app/taxonomy/').$year.'/country-2017-01-31.xsd';
        if (file_exists($countryFilePath)){
            $taxFile = Storage::disk('taxonomy')->get($year . '/country-2017-01-31.xsd');
            $this->taxonomyData[] = XmlToArray::convert($taxFile);
        }
        $currencyFilePath = storage_path('app/taxonomy/').$year.'/currency-2017-01-31.xsd';
        if (file_exists($currencyFilePath)){
            $taxFile = Storage::disk('taxonomy')->get($year . '/currency-2017-01-31.xsd');
            $this->taxonomyData[] = XmlToArray::convert($taxFile);
        }

        return $this->taxonomyData;
    }

    private function getDefinitionData($year = '2019'){
        $deiDoc = Storage::disk('taxonomy')->get($year. '/dei-doc-' . $year. '-01-31.xml');
        $this->definitionData[] = XmlToArray::convert($deiDoc);

        $usGaapDoc = Storage::disk('taxonomy')->get($year . '/us-gaap-doc-' . $year . '-01-31.xml');
        $this->definitionData[] = XmlToArray::convert($usGaapDoc);

        $srtDoc = Storage::disk('taxonomy')->get($year . '/srt-doc-' . $year . '-01-31.xml');
        $this->definitionData[] = XmlToArray::convert($srtDoc);
    }

    private function getLabelData($year = '2019'){
        $deiLab = Storage::disk('taxonomy')->get($year . '/dei-lab-' . $year . '-01-31.xml');
        $this->labelData[] = XmlToArray::convert($deiLab);

        $usGaapLab = Storage::disk('taxonomy')->get($year . '/us-gaap-lab-' . $year . '-01-31.xml');
        $this->labelData[] = XmlToArray::convert($usGaapLab);

        $srtLab = Storage::disk('taxonomy')->get($year . '/srt-lab-' . $year . '-01-31.xml');
        $this->labelData[] = XmlToArray::convert($srtLab);
    }

    public function getMonetaryElementsFromTaxonomy()
    {
        $taxonomyElements = ($this->clientBuilder->search([
            'index' => 'taxonomy_2019',
            'type' => 'element',
            'body' => [
                'size' => '10000',
                'query' => [
                    "bool" => [
                        "must" => [
                            "match" => [
                                "type" => "xbrli:monetaryItemType"
                            ]
                        ],
                    ]
                ],
            ],
        ]));
        $monetary = [];
        if (!empty($taxonomyElements['hits']['hits'])){
            foreach ($taxonomyElements['hits']['hits'] as $el){
                $monetary[] = [
                    'name' => $el['_source']['name'],
                    'code' => $el['_source']['code'],
                ];
            }
        }
        return $monetary;
    }

    public function getAllTaxonomyElements(){
        $parents = [];
        $taxonomyElements = ($this->clientBuilder->search([
            'index' => 'taxonomy_2019',
            'type' => 'element',
            'body' => [
                'size' => '10000',
                "query" => [
                    "match_all" => [
                        "boost" => 1.0,
                    ],
                ],
            ],
        ]));

        foreach ($taxonomyElements['hits']['hits'] as $el){
            $parents[] = [
                'code' => $el['_source']['code'],
                'name' => $el['_source']['name'],
            ];
        }

        return $parents;
    }

    function filterByCompany($companyId)
    {
        $query = [
            "bool" => [
                "should" => [
                    [
                        "bool" => [
                            "must_not" => [
                                "exists" => [
                                    "field" => "company_id"
                                ]
                            ]
                        ]
                    ],
                    [
                        "bool" => [
                            "must" => [
                                [
                                    "term" => [
                                        "company_id" => $companyId
                                    ]
                                ],
                                [
                                    "term" => [
                                        "client_id" => Client::getCurrentClientId()
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $query;
    }

    public function searchTag($text, $type = null, $substitutionGroup = null, $parentId = null, $elasticResults = false, $companyId = null)
    {
        if (!is_null($companyId)) {
            $query['should'] = $this->filterByCompany($companyId);
        }

        $query = [
            'must' => [
                [
                    "bool" => [
                        'should' => [
                            [
                                "query_string" => [
                                    "query" => $text,
                                    "default_field" => "name",
                                ]
                            ],
                            [
                                "match" => [
                                    "label.content" => [
                                        "query" => $text,
                                        "minimum_should_match" => "50%",
                                        "boost" => 3
                                    ]

                                ],
                            ]
                        ]
                    ]
                ],
                [
                    'exists' => [
                        'field' => 'code'
                    ]
                ]
            ]
        ];

        if (!is_null($type)) {
            $query['must'][] =
                [
                    "term" => [
                        "type.keyword" => $type
                    ]
                ];
        }

        if (!is_null($substitutionGroup)) {
            $query['must'][] =
                [
                    "term" => [
                        "substitutionGroup.keyword" => $substitutionGroup
                    ]
                ];
        }

        if (!is_null($parentId)) {
            $query['must'][] =
                [
                    "terms" => [
                        "parent_id" => [$parentId]
                    ]
                ];
        }


        $results = ($this->clientBuilder->search([
            "index" => "taxonomy_2019",
            "body" => [
                "size" => "100",
                "query" => [
                    "bool" => $query
                ]
            ]
        ]));

        if (!empty($results['hits']['hits'])) {
            if ($elasticResults) {
                return $results['hits']['hits'];
            } else {
                return $this->prepareResultsToRender($results['hits']['hits']);
            }
        } else {
            return null;
        }
    }

    function prepareResultsToRender($results){
        $preparedResults = [];
        foreach ($results as $result){
            if (!isset($result['_source']['label'])){
                $result['_source']['label'][] = [
                    'content' => $result['_source']['name']
                ];
            }
            foreach ($result['_source']['label'] as $label){
                $preparedResults[] = [
                    'code' => $result['_source']['code'],
                    'label' => $label['content']
                ];
//                $preparedResults[$result['_source']['code']] = $label['content'];
            }
        }

        return $preparedResults;
    }

    function getTaxonomyConceptNamespaces(){
        $results = ($this->clientBuilder->search([
            "index" => "taxonomy_2019",
            "body" => [
                "aggregations" => [
                    "byFieldName" => [
                        "terms" => [
                            "field" => "namespace.keyword"
                        ]
                    ]
                ]
            ]
        ]));

        if (!empty($results['aggregations']['byFieldName']['buckets'])) {
            return $results['aggregations']['byFieldName']['buckets'];
        } else {
            return null;
        }
    }

    function getElementDataByCode($tagCode, $elasticResults = false){
        $taxonomyElement = ($this->clientBuilder->search([
            'index' => 'taxonomy_2019',
            'type' => 'element',
            'body' => [
                'size' => '10',
                'query' => [
                    "bool" => [
                        "must"=>[
                            "match"=> [
                                "name" => "$tagCode"
                            ]
                        ],
                    ]
                ],
            ],
        ]));

        if (!empty($taxonomyElement['hits']['hits'])){
            if ($elasticResults){
                return $taxonomyElement['hits']['hits'][0];
            } else {
                return $this->prepareTagDataForRender($taxonomyElement['hits']['hits'][0]['_source']);
            }
        } else {
            return null;
        }
    }

    function getElementDataByLabel($tagLabel, $elasticResults = true){
        $taxonomyElement = ($this->clientBuilder->search([
            'index' => 'taxonomy_2019',
            'type' => 'element',
            'body' => [
                'size' => '10',
                'query' => [
                    "bool" => [
                        "must"=> [
                            [
                                "term"=> [
                                    "label.content.keyword" => "$tagLabel"
                                ]
                            ],
                            [
                                'exists' => [
                                    'field' => 'code'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ]));

        if (!empty($taxonomyElement['hits']['hits'])){
            if ($elasticResults){
                return $taxonomyElement['hits']['hits'][0];
            } else {
                return $this->prepareTagDataForRender($taxonomyElement['hits']['hits'][0]['_source']);
            }
        } else {
            return null;
        }
    }

    function checkIfElementIsAvailable($tagCode){
        $taxonomyElement = ($this->clientBuilder->search([
            'index' => 'taxonomy_2019',
            'type' => 'element',
            'body' => [
                'size' => '1',
                'query' => [
                    "bool" => [
                        "must"=>[
                            "match"=> [
                                "name" => "$tagCode"
                            ]
                        ],
                    ]
                ],
            ],
        ]));
        if (!empty($taxonomyElement['hits']['hits'])){
            return true;
        } else {
            return false;
        }
    }

    function prepareTagDataForRender($tagData){
        $labels = $tagData['label'];
        unset($tagData['label']);
        if (is_array($labels)){
            foreach ($labels as $label){
                $labelType = $this->checkLabelType($label);
                $labelContent = $label['content'];
                $tagData[$labelType] = $labelContent;
            }
        }

        return $tagData;
    }

    function checkLabelType($label){
        preg_match("/[^\/]+$/", $label['role'], $matches);
        $label = $matches[0];

        return $label;
    }

    function getTaxonomyElementWhereLike($text){
        $results = ($this->clientBuilder->search([
            'index' => 'taxonomy_2019',
            'body' => [
                'size' => '10000',
                'query' => [
                    "bool"=>[
                        "must" => [
                            [
                                "wildcard" => [
                                    "name" => "$text"
                                ],
                            ]
                        ]
                    ],
                ],
            ],
        ]));

        if (!empty($results['hits']['hits'])) {
            return $results['hits']['hits'];
        } else {
            return null;
        }
    }

    function getTaxonomyLineItemByTable($tableElement){
        $results = $this->searchTag('LineItems', null, null, $tableElement['_id'], true);

        return $results[0];
    }

    function getElementById($elementId, $elasticResults = true){
        $taxonomyElement = ($this->clientBuilder->search([
            'index' => 'taxonomy_2019',
            'type' => 'element',
            'body' => [
                'size' => '10',
                'query' => [
                    "bool" => [
                        "must"=>[
                            "match"=> [
                                "_id" => "$elementId"
                            ]
                        ],
                    ]
                ],
            ],
        ]));

        if (!empty($taxonomyElement['hits']['hits'])){
            if ($elasticResults){
                return $taxonomyElement['hits']['hits'][0];
            } else {
                return $this->prepareTagDataForRender($taxonomyElement['hits']['hits'][0]['_source']);
            }
        } else {
            return null;
        }
    }

    function splitTagNameAndId($tag){
        $data = explode("[", $tag, 2);
        $tagName = $data[0];
        preg_match_all("/\[([^\]]*)\]/", $tag, $matches);
        $tagId = $matches[1][0];

        return ['tag_id' => $tagId, 'tag_name' => $tagName];
    }

    function updateMultiDimensionalPresentationTree($parentId, $newElementData){
        $ids = explode('_', $parentId);
        $roleId = $ids[0];
        unset($ids[0]);

        $query = [
            "term" => [
                "_id" => $roleId
            ]
        ];

        $taxonomyElements = ($this->clientBuilder->search([
            'index' => 'taxonomy_2019',
            'type' => 'element',
            'body' => [
                'size' => '1000',
                'query' => $query,
            ],
        ]));

        $data = json_decode($taxonomyElements['hits']['hits'][0]['_source']['tree'], JSON_PRETTY_PRINT);

        $this->updateMultiDimensionalArrayItem($data, $ids, $newElementData);

        $params = [
            'index' => 'taxonomy_2019',
            'id'    => $roleId,
            'body'  => [
                'doc' => [
                    'tree' => json_encode($data)
                ]
            ]
        ];

        $this->clientBuilder->update($params);
    }

    function updateMultiDimensionalArrayItem(&$array, $keyPath, $value) {
        if (count($keyPath) === 0) {
            $array[] = $value;
            return;
        }

        $firstKey = reset($keyPath);
        foreach ($array as $key => &$item){
            if ((int)$key === (int)$firstKey && count($keyPath) > 0){
                if (is_array($item)){
                    unset($keyPath[array_key_first($keyPath)]);
                    $this->updateMultiDimensionalArrayItem($item, $keyPath, $value);
                }
            }
        }
    }

}
