<?php

namespace App\Modules\Filing\Logic\XBRL\TaxonomyExtension;

use App\Modules\Taxonomy\Logic\Taxonomy;
use Illuminate\Support\Facades\File;
use Sabre\Xml\Service;

include base_path().'/vendor/autoload.php';


class CalculationExtension extends TaxonomyExtension {

    private $service;
    private $writer;
    public $filingId;
    private $sections;
    private $roleRef = [];
    private $calculationItems = [];
    private $locators = [];
    private $relations = [];
    private $calculationArcRelations = [];


    public function __construct($sections, $filingId)
    {
        $this->sections = $sections;
        $this->filingId = $filingId;
        parent::__construct();
        $this->service = new Service();
        $this->generateRoleRef();
    }

    public function generateCal(){
        $ns = '{http://www.xbrl.org/2003/linkbase}link';
        $this->service->namespaceMap['http://www.xbrl.org/2003/linkbase'] = '';

        $rootAttributes = $this->generateRootAttributes();

        $this->writer = ($this->service->write($ns.':linkbase', function ($writer) use ($rootAttributes, $ns) {
            $writer->writeAttributes($rootAttributes);
                if (!empty($this->roleRef)) {
                    foreach ($this->roleRef as $id => $roleType) {
                        $writer->writeElement($ns . ':roleRef', function ($writer) use ($id) {
                            $writer->writeAttributes(['roleURI' => $this->company->uri.'/role/' . trim($id), 'xlink:href' => $this->schemaFileName . '#' . trim($id), 'xlink:type' => 'simple']);
                        });
                    }

                    foreach ($this->roleRef as $id => $roleType) {
                        $writer->writeElement($ns . ':calculationLink', function ($writer) use ($id, $ns, $roleType) {
                            $writer->writeAttributes(['xlink:role' => $this->company->uri . '/role/' . trim($id), 'xlink:type' => 'extended']);
                            if (!empty($roleType['locators']) && !empty($roleType['relations'])){
                                $this->renderLocators($writer, $ns, $roleType['locators']);
                                $this->renderCalculationArc($writer, $ns, $roleType['relations']);
                            }
                        });
                    }
                }
        }));

        $xmlFileName = $this->calFileName;
        $xmlFilePath = storage_path($xmlFileName);
        File::put($xmlFilePath, $this->writer);

        return [$xmlFileName => $xmlFilePath];
    }

    function renderLocators($writer, $ns, $locators){
        if (!empty($locators)){
            foreach ($locators as $item){
                $writer->writeElement($ns . ':loc', function ($writer) use ($item) {
                    $writer->writeAttributes(['xlink:href' => $item['namespace'], 'xlink:label' => $item['label'], 'xlink:type' => 'locator']);
                });
            }
        }
    }
    function renderCalculationArc($writer, $ns, $calculationItems){
        if (!empty($calculationItems)){
            foreach ($calculationItems as $item){
                $writer->writeElement($ns . ':calculationArc', function ($writer) use ($item) {
                    $writer->writeAttributes([
                        'order' => (string)$item['order'],
                        'weight' => $item['sign'],
                        'xlink:arcrole' => 'http://www.xbrl.org/2003/arcrole/summation-item',
                        'xlink:from' => $item['parent'],
                        'xlink:to' => $item['child'],
                        'xlink:type' => 'arc',
                    ]);
                });
            }
        }

    }
    public function generateRoleRef(){
        if (!empty($this->sections)){
            foreach ($this->sections as $section){
                if (isset($section['tags'])){
                    $this->getCalculationTags($section['tags']);
                    $this->prepareCalculationElements();
                    $this->roleRef[$section['attributes']['section']] = [
                        'locators' => $this->locators,
                        'relations' => $this->relations
                    ];
                }
                $this->locators = [];
                $this->relations = [];
                $this->calculationItems = [];
                $this->calculationArcRelations = [];
            }
        }
    }

    function prepareCalculationElements(){
        if (!empty($this->calculationItems)){
            foreach ($this->calculationItems as $item){
                $sign = '1';
                $element = $this->taxonomy->getElementDataByLabel($item['attributes']['tag'], false);
                $parent = $this->taxonomy->getElementDataByLabel($item['attributes']['sum'], false);
                $this->prepareCalculationLocators([$element, $parent]);

                if (!$this->checkIfRelationExists($element, $parent)) {
                    if (isset($item['attributes']['signvalue']) && $item['attributes']['signvalue'] === 'negative') {
                        $sign = '-1';
                    }

                    $this->relations[] = [
                        'parent' => 'lab_' . $parent['code'],
                        'child' => 'lab_' . $element['code'],
                        'order' => '1',
                        'sign' => $sign
                    ];
                }

            }
        }
    }

    function checkIfRelationExists($parent, $child){
        if (in_array($parent['code'] . '-' . $child['code'], $this->calculationArcRelations)){
            return true;
        }
        $this->calculationArcRelations[] = $parent['code'] . '-' . $child['code'];

        return false;
    }

    function prepareCalculationLocators($locators){
        foreach ($locators as $locator){
            if (!in_array($locator['code'], $this->locators)){
                $this->locators[$locator['code']] = [
                    'label' => 'lab_' . $locator['code'],
                    'namespace' => $this->getNamespaceHref($locator['namespace']) . '#' . $locator['code']
                ];
            }
        }
    }
    function getCalculationTags($tags){
        foreach ($tags as $key => $tag){
            if (isset($tag['attributes']['sum']) && $tag['attributes']['sum'] !== ''){
                $parentElement = $this->taxonomy->getElementDataByLabel($tag['attributes']['sum'], false);
                $childElement = $this->taxonomy->getElementDataByLabel($tag['attributes']['tag'], false);
                if ($childElement['type'] === 'xbrli:monetaryItemType' && $parentElement['type'] === 'xbrli:monetaryItemType'){
                    $this->calculationItems[] = $tag;
                }
            }
        }
    }

    public function generateRootAttributes(){
        $rootAttributes = [
            'xmlns:'.$this->company->symbol => $this->company->uri . '/20190930',
            'xmlns:xlink'=>'http://www.w3.org/1999/xlink',
            'xmlns:link'=>'http://www.xbrl.org/2003/linkbase',
            'xmlns:xsi'=>'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation'=>'http://www.xbrl.org/2003/linkbase http://www.xbrl.org/2003/xbrl-linkbase-2003-12-31.xsd',
        ];

        return $rootAttributes;
    }

//    public function prepareCalculationElements($tags){
//        $tags = $this->checkDuplicates($tags);
//        $usedItems = [];
//        $elements = [];
//        foreach ($tags as $tag){
//            $countUsedItems = count($usedItems);
//            $count = count($elements);
//            $el = $this->taxonomy->getElementDataByLabel($tag['attributes']['tag'], false);
//            $checker = $this->checkIfElementIsUsed($usedItems, $el['code']);
//            if ($checker === false) {
//                $elements[$count]['code'] = $el['code'];
//                $elements[$count]['namespace'] = $this->getNamespaceHref($el['namespace']) . '#' . $el['code'];
//                $elements[$count]['label'] = 'lab_' . $el['code'];
//                $usedItems[$countUsedItems]['code'] = $el['code'];
//                $usedItems[$countUsedItems]['order'] = '0';
//            }
//
//            if (isset($tag['attributes']['sum'])){
//                $count = count($elements);
//                $countUsedItems = count($usedItems);
//                $sumEl = $this->taxonomy->getElementDataByLabel($tag['attributes']['sum'], false);
//                $checker = $this->checkIfElementIsUsed($usedItems, $sumEl['code']);
//                if ($checker === false) {
//                    $elements[$count]['code'] = $sumEl['code'];
//                    $elements[$count]['namespace'] = $this->getNamespaceHref($sumEl['namespace']) . '#' . $sumEl['code'];
//                    $elements[$count]['label'] = 'lab_' . $sumEl['code'];
//                    $elements[$count + 1]['parent'] = 'lab_' . $sumEl['code'];
//                    $elements[$count + 1]['child'] = 'lab_' . $el['code'];
//                    $elements[$count + 1]['order'] = '1';
//                    if (isset($tag['attributes']['signvalue']) && $tag['attributes']['signvalue'] === 'negative') {
//                        $elements[$count + 1]['sign'] = '-1';
//                    } else {
//                        $elements[$count + 1]['sign'] = '1';
//                    }
//                    $usedItems[$countUsedItems]['code'] = $sumEl['code'];
//                    $usedItems[$countUsedItems]['order'] = '1';
//                } else {
//                    $count = count($elements);
//                    $elements[$count]['parent'] = 'lab_' . $sumEl['code'];
//                    $elements[$count]['child'] = 'lab_' . $el['code'];
//                    $order = $this->getOrder($usedItems, $sumEl['code']);
//                    $elements[$count]['order'] = $order;
//                    if (isset($tag['attributes']['signvalue']) && $tag['attributes']['signvalue'] === 'negative') {
//                        $elements[$count]['sign'] = '-1';
//                    } else {
//                        $elements[$count]['sign'] = '1';
//                    }
//                }
//            }
//        }
//        return $elements;
//    }
    function checkDuplicates($elements){
        if (!empty($elements)) {
            foreach ($elements as $key => $element) {
                $bool = $this->checkIfTagsIsUsed($elements, $element);
                if ($bool){
                    unset($elements[$key]);
                }
            }
        }
        return $elements;
    }

    function checkIfTagsIsUsed($elements, $element){
        $counter = 0;
        if (!empty($elements)){
            foreach ($elements as $key1 => $item){
                if ($item['attributes']['tag'] === $element['attributes']['tag']){
                    $counter++;
                }
            }
            if ($counter > 1){
                return true;
            }
        }
    }
}
