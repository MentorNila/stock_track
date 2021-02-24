<?php

namespace App\Modules\Filing\Logic\XBRL\TaxonomyExtension;

use App\Modules\Taxonomy\Logic\Taxonomy;
use App\Modules\Taxonomy\Models\ElementRelation;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\File;
use Sabre\Xml\Service;

include base_path().'/vendor/autoload.php';


class DefinitionExtension extends TaxonomyExtension {

    private $service;
    private $relations = [];
    private $locators = [];
    private $writer;
    public $filingId;
    private $sections;
    private $roleRef = [];

    public function __construct($sections, $filingId)
    {
        $this->sections = $sections;
        $this->filingId = $filingId;
        parent::__construct();
        $this->service = new Service();
        $this->generateRoleRef();
    }

    public function generateDef(){
        $ns = '{http://www.xbrl.org/2003/linkbase}link';
        $this->service->namespaceMap['http://www.xbrl.org/2003/linkbase'] = '';

        $rootAttributes = $this->generateRootAttributes();

        $this->writer = ($this->service->write($ns.':linkbase', function ($writer) use ($rootAttributes, $ns) {
            $writer->writeAttributes($rootAttributes);
            $writer->writeElement($ns . ':arcroleRef', function ($writer) {
                $writer->writeAttributes([
                    'arcroleURI' => 'http://xbrl.org/int/dim/arcrole/all',
                    'xlink:type' => 'simple',
                    'xlink:href' => 'http://www.xbrl.org/2005/xbrldt-2005.xsd#all'
                ]);
            });
            $writer->writeElement($ns . ':arcroleRef', function ($writer) {
                $writer->writeAttributes([
                    'arcroleURI' => 'http://xbrl.org/int/dim/arcrole/hypercube-dimension',
                    'xlink:type' => 'simple',
                    'xlink:href' => 'http://www.xbrl.org/2005/xbrldt-2005.xsd#hypercube-dimension'
                ]);
            });
            $writer->writeElement($ns . ':arcroleRef', function ($writer) {
                $writer->writeAttributes([
                    'arcroleURI' => 'http://xbrl.org/int/dim/arcrole/dimension-default',
                    'xlink:type' => 'simple',
                    'xlink:href' => 'http://www.xbrl.org/2005/xbrldt-2005.xsd#dimension-default'
                ]);
            });
            $writer->writeElement($ns . ':arcroleRef', function ($writer) {
                $writer->writeAttributes([
                    'arcroleURI' => 'http://xbrl.org/int/dim/arcrole/domain-member',
                    'xlink:type' => 'simple',
                    'xlink:href' => 'http://www.xbrl.org/2005/xbrldt-2005.xsd#domain-member'
                ]);
            });
            $writer->writeElement($ns . ':arcroleRef', function ($writer) {
                $writer->writeAttributes([
                    'arcroleURI' => 'http://xbrl.org/int/dim/arcrole/dimension-domain',
                    'xlink:type' => 'simple',
                    'xlink:href' => 'http://www.xbrl.org/2005/xbrldt-2005.xsd#dimension-domain'
                ]);
            });
            if (!empty($this->roleRef)) {
                foreach ($this->roleRef as $id => $roleType) {
                    $writer->writeElement($ns . ':roleRef', function ($writer) use ($roleType, $id) {
                        $writer->writeAttributes(['roleURI' => $this->company->uri.'/role/' . trim($roleType['id']), 'xlink:href' => $this->schemaFileName . '#' . trim($roleType['id']), 'xlink:type' => 'simple']);
                    });
                }
                foreach ($this->roleRef as $id => $roleType) {
                    $writer->writeElement($ns . ':definitionLink', function ($writer) use ($roleType, $id, $ns) {
                        $writer->writeAttributes(['xlink:role' => $this->company->uri.'/role/' . trim($roleType['id']), 'xlink:type' => 'extended']);
                        if (isset($roleType['tags']) && !empty($roleType['tags'])){
                            $defItems = $this->prepareDefinitionElements($roleType['tags'], $roleType);
                            $this->relations = [];
                            $this->locators = [];
                            foreach ($defItems as $item) {
                                if (isset($item['relation'])){
                                    $writer->writeElement($ns . ':definitionArc', function ($writer) use ($item) {
                                        $writer->writeAttributes($this->prepareDefinitionArcItem($item));
                                    });
                                } else {
                                    $writer->writeElement($ns . ':loc', function ($writer) use ($item) {
                                        $writer->writeAttributes($this->prepareDefinitionLocItem($item));
                                    });
                                }
                            }
                        }
                    });
                }
            }
        }));

        $xmlFileName = $this->defFileName;
        $xmlFilePath = storage_path($xmlFileName);
        File::put($xmlFilePath, $this->writer);

        return [$xmlFileName => $xmlFilePath];
    }

    function prepareDefinitionArcItem($item){
        $data = [
            'xlink:type' => 'arc',
            'xlink:arcrole' => $item['relation'],
            'xlink:from' => $item['parent'],
            'xlink:to' => $item['child'],
            'use' => 'optional',
            'order' => (string)$item['order'],
        ];
        if (isset($item['xbrldt:contextElement'])){
            $data['xbrldt:contextElement'] = $item['xbrldt:contextElement'];
        }

        if (isset($item['xbrldt:contextElement'])){
            $data['xbrldt:closed'] = $item['xbrldt:closed'];
        }

        return $data;
    }
    function prepareDefinitionLocItem($item){
        return [
            'xlink:href' => $item['namespace'],
            'xlink:label' => $item['label'],
            'xlink:type' => 'locator'
        ];
    }

    public function generateRoleRef()
    {
        if (!empty($this->sections)) {
            foreach ($this->sections as &$section) {
                if ($this->isValidDimensionalSection($section)) {
                    $counter = count($this->roleRef);
                    $this->roleRef[$counter]['id'] = $section['attributes']['section'];
                    $this->roleRef[$counter]['name'] = $section['attributes']['section'];
                    $this->roleRef[$counter]['table'] = $section['attributes']['table'];
                    $this->roleRef[$counter]['lineitem'] = $section['attributes']['lineitem'];

                    if (isset($section['tags'])) {
                        $this->roleRef[$counter]['tags'] = $section['tags'];
                    }
                }
            }
        }
    }

    function isValidDimensionalSection(&$section){
        if (isset($section['attributes']['table']) && isset($section['attributes']['lineitem'])){
            $table = $this->taxonomy->getElementDataByLabel($section['attributes']['table'], true);

            if (!is_null($table)){
                $section['attributes']['table'] = $table;
                return true;
            }
        }

        return false;
    }

    public function generateRootAttributes(){
        $rootAttributes = [
            'xmlns:'.$this->company->symbol => $this->company->uri . '/20190930',
            'xmlns:xlink' => 'http://www.w3.org/1999/xlink',
            'xmlns:link' => 'http://www.xbrl.org/2003/linkbase',
            'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.xbrl.org/2003/linkbase http://www.xbrl.org/2003/xbrl-linkbase-2003-12-31.xsd',
            'xmlns:xbrldt' => 'http://xbrl.org/2005/xbrldt',
        ];

        return $rootAttributes;
    }

    public function prepareDefinitionElements($tags, $roleType)
    {
        $table = $roleType['table'];
        $elements = [];
        $lineItemElement = $this->taxonomy->getElementDataByLabel($roleType['lineitem'], true);
        foreach ($tags as $tag) {
            $dimensions = [];
            if (isset($tag['attributes']['dimensions']) && !is_null($tag['attributes']['dimensions']) && !empty($tag['attributes']['dimensions'])) {
                foreach ($tag['attributes']['dimensions'] as $dimension) {
                    $data = $this->getDimensionData($dimension);
                    if (!empty($data)) {
                        $dimensions[] = [
                            'axis' => $data['axis'],
                            'member' => $data['member'],
                            'domain' => $data['domain']
                        ];
                    }
                }
                $elements = array_merge($elements, $this->generateRelations($dimensions, $table, $lineItemElement));
            }
            $element = $this->taxonomy->getElementDataByLabel($tag['attributes']['tag'], true);
            $lineItemLineItemConcept = $this->generateDomainMemberElements($lineItemElement['_source'], $element['_source']);
            $elements = array_merge($elements, $lineItemLineItemConcept);
        }

        return $elements;
    }

    function checkIfLocatorExists($element){
        if (in_array($element['code'], $this->locators)){
            return true;
        }
        $this->locators[] = $element['code'];
        return false;
    }

    function generateAllRoleElements($lineItem, $table){
        $elements = [];
        if (!$this->checkIfRelationExists($lineItem, $table)){
            if (!$this->checkIfLocatorExists($table)){
                $elements[] = [
                    'code' => $table['code'],
                    'namespace' => $this->getNamespaceHref($table['namespace']) . '#' . $table['code'],
                    'label' => 'lab_' . $table['code']
                ];
            }
            if (!$this->checkIfLocatorExists($lineItem)){
                $elements[] = [
                    'code' => $lineItem['code'],
                    'namespace' => $this->getNamespaceHref($lineItem['namespace']) . '#' . $lineItem['code'],
                    'label' => 'lab_' . $lineItem['code']
                ];
            }

            $elements[] = [
                'parent' => $lineItem['code'],
                'child' => $table['code'],
                'relation' => 'http://xbrl.org/int/dim/arcrole/all',
                'order' => '1',
                "xbrldt:contextElement" => "segment",
                "xbrldt:closed" => "true"
            ];
        }


        return $elements;
    }
    function checkIfRelationExists($parent, $child){
        if (in_array($parent['code'] . '-' . $child['code'], $this->relations)){
            return true;
        }
        $this->relations[] = $parent['code'] . '-' . $child['code'];

        return false;
    }

    function generateHyperCubeDimensionElements($table, $axis){
        $elements = [];
        if (!$this->checkIfRelationExists($table, $axis)){
            if (!$this->checkIfLocatorExists($axis)){
                $elements[] = [
                    'code' => $axis['code'],
                    'namespace' => $this->getNamespaceHref($axis['namespace']) . '#' . $axis['code'],
                    'label' => 'lab_' . $axis['code']
                ];
            }

            $elements[] = [
                'parent' => $table['code'],
                'child' => $axis['code'],
                'relation' => 'http://xbrl.org/int/dim/arcrole/hypercube-dimension',
                'order' => '1'
            ];
        }

        return $elements;
    }

    /**
     * @param $axis
     * @param $domain
     *
     * Includes dimension-default relation
     */
    function generateDimensionDomainElements($axis, $domain){
        $elements = [];
        if (!$this->checkIfRelationExists($axis, $domain)){
            if (!$this->checkIfLocatorExists($domain)){
                $elements[] = [
                    'code' => $domain['code'],
                    'namespace' => $this->getNamespaceHref($domain['namespace']) . '#' . $domain['code'],
                    'label' => 'lab_' . $domain['code']
                ];
            }

            $elements[] = [
                'parent' => $axis['code'],
                'child' => $domain['code'],
                'relation' => 'http://xbrl.org/int/dim/arcrole/dimension-domain',
                'order' => '1',
            ];

            $elements[] = [
                'parent' => $axis['code'],
                'child' => $domain['code'],
                'relation' => 'http://xbrl.org/int/dim/arcrole/dimension-default',
                'order' => '1',
            ];
        }

        return $elements;
    }

    function generateDomainMemberElements($domain, $member){
        $elements = [];
        if (!$this->checkIfRelationExists($domain, $member)){
            if (!$this->checkIfLocatorExists($member)) {
                $elements[] = [
                    'code' => $member['code'],
                    'namespace' => $this->getNamespaceHref($member['namespace']) . '#' . $member['code'],
                    'label' => 'lab_' . $member['code']
                ];
            }

            $elements[] = [
                'parent' => $domain['code'],
                'child' => $member['code'],
                'relation' => 'http://xbrl.org/int/dim/arcrole/domain-member',
                'order' => '1',
            ];
        }

        return $elements;
    }

    function generateRelations($dimensions, $table, $lineItem){
        $elements = [];
        $allRoleElements = $this->generateAllRoleElements($lineItem['_source'], $table['_source']);
        if (!empty($dimensions)){
            foreach ($dimensions as $item){
                $hyperCubeDimensionElements = $this->generateHyperCubeDimensionElements($table['_source'], $item['axis']['_source']);
                $dimensionDomainElements = $this->generateDimensionDomainElements($item['axis']['_source'], $item['domain']['_source']);
                $domainMemberElements = $this->generateDomainMemberElements($item['domain']['_source'], $item['member']['_source']);
                $elements = array_merge($elements, $allRoleElements, $hyperCubeDimensionElements, $dimensionDomainElements, $domainMemberElements);
            }
        }

        return $elements;
    }

    function getDimensionData($dimension){
        $axis = $this->taxonomy->getElementDataByLabel($dimension['axis'], true);
        $member = $this->taxonomy->getElementDataByLabel($dimension['member'], true);
        $domain = $this->taxonomy->getElementDataByLabel($dimension['domain'], true);

        if (!is_null($axis) && !is_null($member)){
            return [
                'axis' => $axis,
                'member' => $member,
                'domain' => $domain
            ];
        }
        return [];
    }

    public function getElementParent($element){
        $parentId = $element['parent_id'];
        $hosts = ['0.0.0.0:9200'];
        $client = Clientbuilder::create()->build();
        $parent = ($client->search([
            'index' => 'taxonomy_2020',
            'type' => 'element',
            'body' => [
                'size' => '1',
                'query' => [
                    "ids" => [
                        "values" => [$parentId]
                    ]
                ],
            ],
        ]));

        if (!empty($parent['hits']['hits'])){
            return $parent['hits']['hits'][0]['_source'];
        } else {
            return null;
        }

    }
}
