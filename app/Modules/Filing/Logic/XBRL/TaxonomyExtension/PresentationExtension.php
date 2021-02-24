<?php

namespace App\Modules\Filing\Logic\XBRL\TaxonomyExtension;

use App\Modules\Taxonomy\Logic\Taxonomy;
use Illuminate\Support\Facades\File;
use Sabre\Xml\Service;

include base_path().'/vendor/autoload.php';


class PresentationExtension extends TaxonomyExtension {

    private $service;
    private $writer;
    public $filingId;
    private $sections;
    private $presentationItems;
    private $roleRef = [];
    private $presentationArcRelations = [];
    private $locators = [];
    private $relations = [];

    public function __construct($sections, $filingId)
    {
        $this->sections = $sections;
        $this->filingId = $filingId;
        parent::__construct();
        $this->service = new Service();
        $this->generateRoleRef();
    }

    public function generatePre(){
        $ns = '{http://www.xbrl.org/2003/linkbase}link';
        $this->service->namespaceMap['http://www.xbrl.org/2003/linkbase'] = '';

        $rootAttributes = $this->generateRootAttributes();

        $this->writer = ($this->service->write($ns.':linkbase', function ($writer) use ($rootAttributes, $ns) {
            $writer->writeAttributes($rootAttributes);

                if (!empty($this->presentationItems)) {
                    foreach ($this->presentationItems as $id => $presentationItem){
                        $writer->writeElement($ns . ':roleRef', function ($writer) use ($id) {
                            $writer->writeAttributes(['roleURI' => $this->company->uri.'/role/' . trim($id), 'xlink:href' => $this->schemaFileName . '#' . trim($id), 'xlink:type' => 'simple']);
                        });
                    }

                    foreach ($this->presentationItems as $id => $presentationItem){
                        $writer->writeElement($ns . ':presentationLink', function ($writer) use ($presentationItem, $id, $ns) {
                            $writer->writeAttributes(['xlink:role' => $this->company->uri.'/role/' . trim($id), 'xlink:type' => 'extended']);
                            if (!empty($presentationItem)){
                                $this->renderLocators($writer, $ns, $presentationItem);
                                $this->renderPresentationArc($writer, $ns, $presentationItem);
                            }
                        });
                    }
                }
        }));

        $xmlFileName = $this->preFileName;
        $xmlFilePath = storage_path($xmlFileName);
        File::put($xmlFilePath, $this->writer);

        return [$xmlFileName => $xmlFilePath];
    }

    public function generateRoleRef(){
        if (!empty($this->sections)){
            foreach ($this->sections as $section){
                if (isset($section['attributes']['table']) && !is_null($this->taxonomy->getElementDataByLabel($section['attributes']['table']))){
                    $this->presentationItems[$section['attributes']['section']] = $this->prepareDimensionalSection($section);
                } else if ($section['attributes']['section'] !== ''){
                    $this->presentationItems[$section['attributes']['section']] = $this->prepareNonDimensionalSection($section);
                }
                $this->presentationArcRelations = [];
                $this->locators = [];
                $this->relations = [];
            }
        }
    }

    function prepareNonDimensionalSection($section){
        $this->prepareNonDimensionalForPresentation($section);
        return [
            'locators' => $this->locators,
            'relations' => $this->relations
        ];
    }

    function prepareDimensionalSection($section){
        $this->prepareDimensionalForPresentation($section);
        return [
            'locators' => $this->locators,
            'relations' => $this->relations
        ];
    }

    function preparePresentationLocators($locators){
        foreach ($locators as $locator){
            if (!in_array($locator['code'], $this->locators)){
                $this->locators[$locator['code']] = [
                    'label' => 'loc_' . $locator['code'],
                    'namespace' => $this->getNamespaceHref($locator['namespace']) . '#' . $locator['code']
                ];
            }
        }
    }
    function getPreferredLabel($label, $element){
        if (isset($element['labels'])){
            foreach ($element['labels'] as $label){
                if (isset($label['preferred']) && $label['preferred'] === 'on'){
                    return 'http://www.xbrl.org/2003/role/' . $label['type'];
                }
            }
        } else {
            $labels = $element['_source']['label'];
            foreach ($labels as $item){
                if ($item['content'] === trim($label)){
                    return $item['role'];
                }
            }
        }
        return 'http://www.xbrl.org/2003/role/label';
    }

    function prepareNonDimensionalForPresentation($section){
        $abstract = $this->taxonomy->getElementDataByLabel($section['attributes']['abstract'], false);
        foreach ($section['tags'] as $tag){
            $lineItemConcept = $this->taxonomy->getElementDataByLabel($tag['attributes']['tag']);

            if (isset($tag['attributes']['labels'])){
                $lineItemConcept['labels'] = $tag['attributes']['labels'];
            }

            if (!isset($tag['attributes']['sum'])){
                $tag['attributes']['parent'] = $abstract;
            } else {
                $tag['attributes']['parent'] = $this->taxonomy->getElementDataByLabel($tag['attributes']['sum'], false);
            }
            $this->preparePresentationLocators([$lineItemConcept['_source'], $abstract]);

            if (!$this->checkIfRelationExists($lineItemConcept['_source'], $tag['attributes']['parent'])) {
                $this->relations[] = [
                    'child' => 'loc_' . $lineItemConcept['_source']['id'],
                    'parent' => 'loc_' . $tag['attributes']['parent']['id'],
                    'sum' => null,
                    'preferredLabel' => $this->getPreferredLabel($tag['attributes']['tag'], $lineItemConcept)
                ];
            }
        }
    }
    function prepareDimensionalForPresentation($section){
        $abstract = $this->taxonomy->getElementDataByLabel($section['attributes']['abstract'], false);
        $table = $this->taxonomy->getElementDataByLabel($section['attributes']['table'], false);
        $lineItem = $this->taxonomy->getElementDataByLabel($section['attributes']['lineitem'], false);

        $this->preparePresentationLocators([$abstract, $table, $lineItem]);
        $this->relations[] = [
            'child' => 'loc_' . $table['id'],
            'parent' => 'loc_' . $abstract['id'],
            'sum' => null,
            'order' => '1',
            'preferredLabel' => 'http://www.xbrl.org/2003/role/label'
        ];

        $this->relations[] = [
            'child' => 'loc_' . $lineItem['id'],
            'parent' => 'loc_' . $table['id'],
            'sum' => null,
            'order' => '1',
            'preferredLabel' => 'http://www.xbrl.org/2003/role/label'
        ];

        $order = 0;
        foreach ($section['tags'] as $tag){
            $order++;
            $dimensions = [];
            $lineItemConcept = $this->taxonomy->getElementDataByLabel($tag['attributes']['tag']);

            if (isset($tag['attributes']['labels'])){
                $lineItemConcept['labels'] = $tag['attributes']['labels'];
            }

            if (!isset($tag['attributes']['sum'])){
                $tag['attributes']['parent'] = $lineItem;
            } else {
                $tag['attributes']['parent'] = $this->taxonomy->getElementDataByLabel($tag['attributes']['sum'], false);
            }

            $this->preparePresentationLocators([$lineItemConcept['_source']]);

            if (!$this->checkIfRelationExists($lineItemConcept['_source'], $tag['attributes']['parent'])) {
                $this->relations[] = [
                    'child' => 'loc_' . $lineItemConcept['_source']['id'],
                    'parent' => 'loc_' . $tag['attributes']['parent']['id'],
                    'sum' => null,
                    'order' => $order,
                    'preferredLabel' => $this->getPreferredLabel($tag['attributes']['tag'], $lineItemConcept)
                ];
            }

            if (isset($tag['attributes']['dimensions']) && !empty($tag['attributes']['dimensions'])){
                foreach ($tag['attributes']['dimensions'] as $dimension) {
                    $data = $this->getDimensionsData($dimension);
                    $this->preparePresentationLocators($data);

                    if (!empty($data)) {
                        $dimensions[] = [
                            'axis' => $data['axis'],
                            'member' => $data['member'],
                            'domain' => $data['domain']
                        ];
                    }
                    $this->prepareDimensionalRelations($dimensions, $table);
                }
            }
        }
    }

    function getDimensionsData($dimension){
        $axis = $this->taxonomy->getElementDataByLabel($dimension['axis'], false);
        $member = $this->taxonomy->getElementDataByLabel($dimension['member'], false);
        $domain = $this->taxonomy->getElementDataByLabel($dimension['domain'], false);

        return [
            'axis' => $axis,
            'member' => $member,
            'domain' => $domain
        ];
    }

    function checkIfRelationExists($parent, $child){
        if (in_array($parent['code'] . '-' . $child['code'], $this->presentationArcRelations)){
            return true;
        }
        $this->presentationArcRelations[] = $parent['code'] . '-' . $child['code'];

        return false;
    }

    function prepareDimensionalRelations($dimensions, $table){
            foreach ($dimensions as $dimension){
                if (isset($dimension['axis']) && !is_null($dimension['axis'])){
                    if (!$this->checkIfRelationExists($table, $dimension['axis'])) {
                        $this->relations[] = [
                            'child' => 'loc_' . $dimension['axis']['id'],
                            'parent' => 'loc_' . $table['id'],
                            'sum' => null,
                            'preferredLabel' => 'http://www.xbrl.org/2003/role/label'
                        ];
                    }
                    if (isset($dimension['domain']) && !is_null($dimension['domain'])) {
                        if (!$this->checkIfRelationExists($dimension['axis'], $dimension['domain'])) {
                            $this->relations[] = [
                                'child' => 'loc_' . $dimension['domain']['id'],
                                'parent' => 'loc_' . $dimension['axis']['id'],
                                'sum' => null,
                                'preferredLabel' => 'http://www.xbrl.org/2003/role/label'
                            ];
                        }
                        if (isset($dimension['member']) && !is_null($dimension['member'])){
                            if (!$this->checkIfRelationExists($dimension['domain'], $dimension['member'])) {
                                $this->relations[] = [
                                    'child' => 'loc_' . $dimension['member']['id'],
                                    'parent' => 'loc_' . $dimension['domain']['id'],
                                    'sum' => null,
                                    'preferredLabel' => 'http://www.xbrl.org/2003/role/label'
                                ];
                            }
                        }
                    }
                }
            }
    }

    public function generateRootAttributes(){
        $rootAttributes = [
            'xmlns:' . $this->company->symbol => $this->company->uri.'/20190930',
            'xmlns:xlink'=>'http://www.w3.org/1999/xlink',
            'xmlns:link'=>'http://www.xbrl.org/2003/linkbase',
            'xmlns:xsi'=>'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation'=>'http://www.xbrl.org/2003/linkbase http://www.xbrl.org/2003/xbrl-linkbase-2003-12-31.xsd',
        ];

        return $rootAttributes;
    }

    function renderLocators($writer, $ns, $presentationItem){
        if(!empty($presentationItem['locators'])){
            foreach ($presentationItem['locators'] as $item){
                $writer->writeElement($ns . ':loc', function ($writer) use ($item) {
                    $writer->writeAttributes([
                        'xlink:href' => $item['namespace'],
                        'xlink:label' => $item['label'],
                        'xlink:type' => 'locator'
                    ]);
                });
            }
        }
    }

    function renderPresentationArc($writer, $ns, $presentationItem){
        if (!empty($presentationItem['relations'])){
            foreach ($presentationItem['relations'] as $item){
                $writer->writeElement($ns . ':presentationArc', function ($writer) use ($item) {

                    $writer->writeAttributes([
                        'order' => isset($item['order']) ? (string)$item['order']: '0',
                        'xlink:arcrole' => 'http://www.xbrl.org/2003/arcrole/parent-child',
                        'xlink:from' => $item['parent'],
                        'xlink:to' => $item['child'],
                        'use' => 'optional',
                        'xlink:type' => 'arc',
                        'preferredLabel' => $item['preferredLabel'],
                    ]);
                });
            }
        }
    }
}
