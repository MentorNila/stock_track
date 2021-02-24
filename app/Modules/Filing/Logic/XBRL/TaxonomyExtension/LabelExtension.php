<?php

namespace App\Modules\Filing\Logic\XBRL\TaxonomyExtension;

use Illuminate\Support\Facades\File;
use Sabre\Xml\Service;

include base_path().'/vendor/autoload.php';


class LabelExtension extends TaxonomyExtension {

    private $service;
    private $writer;
    public $filingId;
    public $sections;
    public $elements = [];
    private $roleRef = [];
    private $usedLocators = [];
    private $usedLabelArc = [];

    public function __construct($sections, $filingId)
    {
        $this->sections = $sections;
        $this->filingId = $filingId;
        parent::__construct();
        $this->getTaxonomyElement();
        $this->prepareElements();
        $this->service = new Service();
        $this->generateRoleRef();
    }

    public function generateLab(){
        $ns = '{http://www.xbrl.org/2003/linkbase}link';
        $this->service->namespaceMap['http://www.xbrl.org/2003/linkbase'] = '';

        $rootAttributes = $this->generateRootAttributes();
        $this->writer = ($this->service->write($ns.':linkbase', function ($writer) use ($rootAttributes, $ns) {
            $writer->writeAttributes($rootAttributes);
            foreach ($this->roleRef as $item) {
              $writer->writeElement('roleRef', function ($writer) use ($item){
                  $writer->writeAttributes(['xlink:type' => 'simple', 'xlink:href' => $item['xlink:href'], 'roleURI' => $item['roleURI']]);
              });
            }
            $writer->writeElement($ns . ':labelLink', function ($writer) use ($ns){
                $writer->writeAttributes(['xlink:type' => 'extended', 'xlink:role' => 'http://www.xbrl.org/2003/role/link']);
                if (!empty($this->elements)) {
                    foreach ($this->elements as $attr => $element) {
//                        $this->writeLabelLinkElement($writer, $ns, $element['namespace'], $element['code'], $element['label'], '_lab','http://www.xbrl.org/2003/role/label');
                        if (isset($element['labels'])) {
                            $locator = true;
                            foreach ($element['labels'] as $label) {
                                if (isset($label['role'])){
                                    $labelRoleURI = $label['role'];
                                    $label['name'] = $label['content'];
                                    $label['type'] = substr($labelRoleURI, strrpos($labelRoleURI, '/') + 1);
                                } else if(isset($this->roleRef[$label['type']])){
                                    $labelRoleURI = $this->roleRef[$label['type']]['roleURI'];
                                } else {
                                    $labelRoleURI = 'http://www.xbrl.org/2003/role/' . $label['type'];
                                }

                                $this->writeLabelLinkElement($writer, $ns, $element['_source']['namespace'], $element['_source']['code'], $label['name'], '_' . $label['type'], $labelRoleURI, $locator);
                                $locator = false;
                            }
                        }
                    }
                }
            });
        }));

        $xmlFileName = $this->labFileName;
        $xmlFilePath = storage_path($xmlFileName);
        File::put($xmlFilePath, $this->writer);

        return [$xmlFileName => $xmlFilePath];
    }

    public function generateRootAttributes(){
        $rootAttributes = [
            'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
            'xmlns:'.$this->company->symbol => $this->company->uri.'/20190930',
            'xmlns:link' => 'http://www.xbrl.org/2003/linkbase',
            'xmlns:xlink' => 'http://www.w3.org/1999/xlink',
            'xmlns:xbrldt' => 'http://xbrl.org/2005/xbrldt',
            'xmlns:xbrli' => 'http://www.xbrl.org/2003/instance',
            'xsi:schemaLocation' => 'http://www.xbrl.org/2003/linkbase http://www.xbrl.org/2003/xbrl-linkbase-2003-12-31.xsd',
        ];

        return $rootAttributes;
    }

    function writeLabelLinkElement($writer, $ns, $elementNamespace, $elementCode, $label, $labelName, $labelRole, $locator = true){
        if ($locator && !$this->checkIfLocatorIsUsed($elementCode) ){
            $writer->writeElement($ns . ':loc', function ($writer) use ($elementNamespace, $elementCode) {
                $writer->writeAttributes([
                    'xlink:type' => 'locator',
                    'xlink:href' => $this->getNamespaceHref($elementNamespace) . '#' . $elementCode,
                    'xlink:label' => 'loc_' . $elementCode,
                ]);
            });
            $this->usedLocators[] = $elementCode;
        }

        $writer->writeElement($ns . ':label', function ($writer) use ($elementCode, $labelName, $label, $labelRole) {
            $writer->writeAttributes([
                'xlink:type' => 'resource',
                'xlink:role' => $labelRole,
                'xlink:label' => 'lab_' . $elementCode,
                'xml:lang' => 'en-US',
            ]);
            $writer->write($label);
        });

        if (!$this->checkIfLabelArcIsUsed('loc_' . $elementCode . 'lab_' . $elementCode) ) {
            $writer->writeElement($ns . ':labelArc', function ($writer) use ($elementCode, $labelName) {
                $writer->writeAttributes([
                    'xlink:type' => 'arc',
                    'xlink:arcrole' => 'http://www.xbrl.org/2003/arcrole/concept-label',
                    'xlink:from' => 'loc_' . $elementCode,
                    'xlink:to' => 'lab_' . $elementCode,
                ]);
            });

            $this->usedLabelArc[] = 'loc_' . $elementCode . 'lab_' . $elementCode;
        }
    }


    function checkIfLocatorIsUsed($item){
        if (!empty($this->usedLocators)){
            foreach ($this->usedLocators as $locator){
                if ($locator === $item) {
                    return true;
                }
            }
        }

        return false;
    }

    function checkIfLabelArcIsUsed($item){
        if (!empty($this->usedLabelArc)){
            foreach ($this->usedLabelArc as $labelArc){
                if ($labelArc === $item) {
                    return true;
                }
            }
        }

        return false;
    }

    public function generateRoleRef(){
      $this->roleRef['netLabel'] = ['xlink:href' => 'http://www.xbrl.org/lrr/role/net-2009-12-16.xsd#netLabel', 'roleURI' => 'http://www.xbrl.org/2009/role/netLabel'];
      $this->roleRef['negatedLabel'] = ['xlink:href' => 'http://www.xbrl.org/lrr/role/negated-2009-12-16.xsd#negatedLabel', 'roleURI' => 'http://www.xbrl.org/2009/role/negatedLabel'];
      $this->roleRef['negatedPeriodEndLabel'] = ['xlink:href' => 'http://www.xbrl.org/lrr/role/negated-2009-12-16.xsd#negatedPeriodEndLabel', 'roleURI' => 'http://www.xbrl.org/2009/role/negatedPeriodEndLabel'];
      $this->roleRef['negatedPeriodStartLabel'] = ['xlink:href' => 'http://www.xbrl.org/lrr/role/negated-2009-12-16.xsd#negatedPeriodStartLabel', 'roleURI' => 'http://www.xbrl.org/2009/role/negatedPeriodStartLabel'];
      $this->roleRef['negatedTerseLabel'] = ['xlink:href' => 'http://www.xbrl.org/lrr/role/negated-2009-12-16.xsd#negatedTerseLabel', 'roleURI' => 'http://www.xbrl.org/2009/role/negatedTerseLabel'];
      $this->roleRef['negatedTotalLabel'] = ['xlink:href' => 'http://www.xbrl.org/lrr/role/negated-2009-12-16.xsd#negatedTotalLabel', 'roleURI' => 'http://www.xbrl.org/2009/role/negatedTotalLabel'];
      $this->roleRef['negatedNetLabel'] = ['xlink:href' => 'http://www.xbrl.org/lrr/role/negated-2009-12-16.xsd#negatedNetLabel', 'roleURI' => 'http://www.xbrl.org/2009/role/negatedNetLabel'];
    }

    function prepareElements(){
        $elements = [];
        if(!empty($this->elements)){
            foreach ($this->elements as $key => &$element){
                $element = $this->prepareElementLabels($element);
                if (empty($elements)){
                    $elements[] = $element['_source']['code'];
                } else if(in_array($element['_source']['code'], $elements)){
                    unset($this->elements[$key]);
                } else {
                    $elements[] = $element['_source']['code'];
                }
            }
        }
    }

    function prepareElementLabels($element){
        $labels = $element['_source']['label'];
        foreach ($labels as $label){
            $element['labels'][] = $label;
        }
        return $element;
    }
}
