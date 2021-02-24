<?php

namespace App\Modules\Filing\Logic\XBRL;

include base_path().'/vendor/autoload.php';

use App\Modules\Filing\Logic\GetFilingData;
use App\Modules\Filing\Logic\XBRL\EntryGenerator\ContextEntry;
use App\Modules\Filing\Logic\XBRL\EntryGenerator\DeiEntry;
use App\Modules\Filing\Logic\XBRL\EntryGenerator\UnitEntry;
use App\Modules\Filing\Logic\XBRL\TaxonomyExtension\CalculationExtension;
use App\Modules\Filing\Logic\XBRL\TaxonomyExtension\DefinitionExtension;
use App\Modules\Filing\Logic\XBRL\TaxonomyExtension\LabelExtension;
use App\Modules\Filing\Logic\XBRL\TaxonomyExtension\PresentationExtension;
use App\Modules\Filing\Logic\XBRL\TaxonomyExtension\SchemaExtension;
use App\Modules\Filing\Models\Filing;
use App\Modules\Taxonomy\Logic\Taxonomy;
use DateTime;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\File;
use Sabre\Xml\Service;

class XBRLGenerator {
    private $filingId;
    private $service;
    private $writer;
    private $deiEntries = [];
    private $contextEntries = [];
    private $unitEntries = [];
    private $company;
    private $endDate;
    private $filingData;
    private $sections;

    public function __construct( $filingId, $sections)
    {
        $this->filingId = $filingId;
        $this->getFilingData();
        $this->setCompany();
        $this->getEndDate();
        $this->sections = $sections;
        $this->prepareElements();
        $this->prepareSections();
        $this->service = new Service();

    }

    function getFilingData(){
        $this->filingData = new GetFilingData($this->filingId);
    }
    public function setCompany(){
        $this->company = $this->filingData->getCompany();
    }

    public function getEndDate(){
        $this->endDate = $this->filingData->getEndDate();
        $this->endDate = str_replace('-', '', $this->endDate);
    }

    function isSectionValid($section){
        $taxonomy = new Taxonomy();
        if(isset($section['attributes']['abstract'])) {
            $abstract = $taxonomy->getElementDataByLabel($section['attributes']['abstract']);
        }
        if (isset($abstract) && isset($section['attributes']['abstract']) && isset($section['attributes']['section'])
            && $section['attributes']['section'] !== '' && !is_null($abstract)){
            return true;
        }
        return false;
    }

    function prepareSections(){
        foreach ($this->sections as $key => &$section){
            if ($this->isSectionValid($section)){
                if (isset($section['tags'])){
                    foreach ($section['tags'] as $key1 => $item){
                        if (!(isset($item['attributes']['startdate']) || isset($item['attributes']['instant']))) {
                            unset($section['tags'][$key1]);
                        } else if (isset($item['attributes']['parenthetical']) && $item['attributes']['parenthetical'] === 'on' && !isset($section['attributes']['is_parenthetical'])){
                            $this->createOrUpdateParentheticalSection($item, $section['attributes']);
                            unset($section['tags'][$key1]);
                        }
                    }
                }
            } else {
                unset($this->sections[$key]);
            }
        }
    }

    function createOrUpdateParentheticalSection($tagData, $sectionData){
        $key = $this->checkIfSectionExists($sectionData['section'] . 'Parentheticals');
        if ($key === false){
            $attributes = [
                'section' => $sectionData['section'] . 'Parentheticals',
                'abstract' => $sectionData['abstract'],
                'is_parenthetical' => true
            ];

            if (isset($sectionData['table'])){
                $attributes['table'] = $sectionData['table'];
                $attributes['lineitem'] = $sectionData['lineitem'];
            }
            $this->sections[] = [
                'attributes' => $attributes,
                'tags' => [
                    $tagData
                ]
            ];
        } else {
            $this->sections[$key]['tags'][] = $tagData;
        }
    }

    function checkIfSectionExists($sectionCode){
        foreach ($this->sections as $key => $section){
            if ($section['attributes']['section'] === $sectionCode){
                return $key;
            }
        }
        return false;
    }

    public function generate(){
        $instanceDocument = $this->generateInstanceDocument();
        $schemaExtension = new SchemaExtension($this->sections, $this->filingId);
        $schemaFile = $schemaExtension->generateSchema();

        $calExtension = new CalculationExtension($this->sections, $this->filingId);
        $calFile = $calExtension->generateCal();

        $preExtension = new PresentationExtension($this->sections, $this->filingId);
        $preFile = $preExtension->generatePre();

        $labExtension = new LabelExtension($this->sections, $this->filingId);
        $labFile = $labExtension->generateLab();

        $defExtension = new DefinitionExtension($this->sections, $this->filingId);
        $defFile = $defExtension->generateDef();

        return array_merge($instanceDocument, $schemaFile, $calFile, $preFile, $labFile, $defFile);
    }

    public function generateInstanceDocument(){
        $this->service->namespaceMap['http://www.xbrl.org/2003/instance'] = '';
        $rootAttributes = $this->generateRootAttributes();

        $this->writer = ($this->service->write('xbrl', function ($writer) use ($rootAttributes) {
            $writer->writeAttributes($rootAttributes);
            $writer->writeElement('link' . ':schemaRef', function ($writer){
                $writer->writeAttributes(['xlink:type' => 'simple', 'xlink:href' => $this->company->symbol.'-'.$this->endDate.'.xsd']);
            });

            foreach ($this->contextEntries as $contextEntry){
                $contextEntry->xmlSerialize($writer);
            }

            foreach ($this->unitEntries as $unitEntry){
                $unitEntry->xmlSerialize($writer);
            }

            $filing = Filing::select('amendment_flag as dei:AmendmentFlag',
                'fiscal_year_end_date as dei:CurrentFiscalYearEndDate',
                'fiscal_period_focus as dei:DocumentFiscalPeriodFocus',
                'fiscal_year_focus as dei:DocumentFiscalYearFocus')->find($this->filingId)->toArray();
            if(!empty($this->deiEntries)) {
                if (!empty($filing)) {
                    foreach ($filing as $name => $value) {
                        if ($name === 'dei:AmendmentFlag') {
                            if ($value == 1) {
                                $value = 'true';
                            } else {
                                $value = 'false';
                            }
                        }

                        if (!is_null($value)) {
                            $dE = new DeiEntry();
                            $dE->name = $name;
                            $dE->attributes = $this->deiEntries[0]['attributes'];
                            $dE->value = $value;
                            $dE->xmlSerialize($writer);
                        }
                    }
                }

                $cik = new DeiEntry();
                $cik->name = 'dei:EntityCentralIndexKey';
                $cik->attributes = $this->deiEntries[0]['attributes'];
                $cik->value = $this->company->cik;
                $cik->xmlSerialize($writer);

                foreach ($this->deiEntries as $deiEntry) {
                    $dE = new DeiEntry();
                    $dE->name = $deiEntry['name'];
                    $dE->attributes = $deiEntry['attributes'];
                    $dE->value = $deiEntry['value'];
                    $dE->xmlSerialize($writer);
                }
            }
        }));

        $xmlFileName = $this->company->symbol.'-'.$this->endDate.'.xml';
        $xmlFilePath = storage_path($xmlFileName);
        File::put($xmlFilePath, $this->writer);

        return [$xmlFileName => $xmlFilePath];
    }

    public function prepareElements(){
        $taxonomy = new Taxonomy();
        foreach($this->sections as $section) {
            if (isset($section['attributes']['tag']) && isset($section['attributes']['fact'])){
                $section['tags'][] = [
                    'attributes' =>  $section['attributes']
                ];
            }
            foreach ($section['tags'] as $item){
                if (!empty($item)) {
                    if (isset($item['attributes']['tag']) && $item['attributes']['tag'] !== '' && isset($item['attributes']['fact'])) {
                        $tag = $taxonomy->getElementDataByLabel($item['attributes']['tag'], true);

                        $contextEntry = new ContextEntry();
                        $contextEntry = $this->setDateToContext($contextEntry, $item['attributes']);
                        if(!is_null($contextEntry->id)){
                            if (isset($item['attributes']['dimensions']) && !is_null($item['attributes']['dimensions']) && !empty($item['attributes']['dimensions'])){
                                $contextEntry = $this->setAxisDataToContext($contextEntry, $item['attributes']['dimensions']);
                            }
                            $decimal = "2";
                            $elementAttributes = $tag['_source'];

                            if (isset($elementAttributes['abstract']) && $elementAttributes['abstract'] == 'true'){
                                continue;
                            }

                            if($elementAttributes['type'] === 'xbrli:booleanItemType'){
                                if (strtolower(trim($item['attributes']['fact'])) === 'yes' || strtolower(trim($item['attributes']['fact'])) === 'true'
                                    || strtolower(trim($item['attributes']['fact'])) == true){
                                    $item['attributes']['fact'] = 'true';
                                } else {
                                    $item['attributes']['fact'] = 'false';
                                }
                            }

                            $unitEntry = new UnitEntry();
                            if ($elementAttributes['type'] !== ''){
                                $unitEntry->decimal = $decimal;
                                $unitEntry = $this->setUnits($unitEntry, $elementAttributes['type']);
                            }

                            if (isset($unitEntry->id)){
                                if (!empty($this->unitEntries)){
                                    if ($this->checkIfUnitExists($unitEntry->id) === false){
                                        $this->unitEntries[] = $unitEntry;
                                    }
                                } else {
                                    $this->unitEntries[] = $unitEntry;
                                }
                                $item['attributes']['fact'] = str_replace(',','', $item['attributes']['fact']);
                                $attributes = ['contextRef' => $contextEntry->id, 'unitRef' => $unitEntry->id, 'decimals' => $unitEntry->decimal];
                            } else {
                                $attributes = ['contextRef' => $contextEntry->id];
                            }

                            $this->deiEntries[] = [
                                'name' => str_replace('_',':',$elementAttributes['code']),
                                'attributes' => $attributes,
                                'value' => $item['attributes']['fact']
                            ];

                            $contextEntry->value = $this->company->cik;
                            $contextEntry->scheme  = "http://www.sec.gov/CIK";

                            if (!empty($this->contextEntries)){
                                if ($this->checkIfContextExists($contextEntry->id) === false){
                                    $this->contextEntries[] = $contextEntry;
                                }
                            } else {
                                $this->contextEntries[] = $contextEntry;
                            }
                        }
                    }
                }
            }
        }
    }

    public function checkIfContextExists($contextId){
        foreach ($this->contextEntries as $entry) {
            if ($entry->id === $contextId){
                return true;
            }
        }
        return false;
    }
    public function checkIfUnitExists($unitId){
        foreach ($this->unitEntries as $entry) {
            if ($entry->id === $unitId){
                return true;
            }
        }
        return false;
    }

    public function generateRootAttributes(){
        $rootAttributes = [
            'xmlns:xsi'=>'http://www.w3.org/2001/XMLSchema-instance',
            'xmlns:xlink'=>'http://www.w3.org/1999/xlink',
            'xmlns:link'=>'http://www.xbrl.org/2003/linkbase',
            'xmlns:xbrli'=>'http://www.xbrl.org/2003/instance',
            'xmlns:xbrldt'=>'http://xbrl.org/2005/xbrldt',
            'xmlns:xbrldi'=>'http://xbrl.org/2006/xbrldi',
            'xmlns:ref'=>'http://www.xbrl.org/2006/ref',
            'xmlns:iso4217'=>'http://www.xbrl.org/2003/iso4217',
            'xmlns:nonnum'=>'http://www.xbrl.org/dtr/type/non-numeric',
            'xmlns:num'=>'http://www.xbrl.org/dtr/type/numeric',
            'xmlns:exch'=>'http://xbrl.sec.gov/exch/2018-01-31',
            'xmlns:naics'=>'http://xbrl.sec.gov/naics/2017-01-31',
            'xmlns:sic'=>'http://xbrl.sec.gov/sic/2011-01-31',
            'xmlns:stpr'=>'http://xbrl.sec.gov/stpr/2018-01-31',
            'xmlns:'.$this->company->symbol=>$this->company->uri.'/'.$this->endDate,
        ];

        $taxonomy = new Taxonomy();
        $namespaces = $taxonomy->getTaxonomyConceptNamespaces();

        if (!is_null($namespaces)){
            foreach ($namespaces as $namespace) {
                if ($namespace['key'] !== '' && $namespace['key'] !== 'defaultNamespace'){
                    $split = explode('/',$namespace['key']);
                    $key = $split[count($split) - 2];
                    $rootAttributes['xmlns:' . $key] = $namespace['key'];
                }

            }
        }

        return $rootAttributes;
    }

    function setAxisDataToContext($contextEntry, $dimensions){
        $i = 0;
        $taxonomy = new Taxonomy();
        foreach ($dimensions as $dimension){
            $axis = $taxonomy->getElementDataByLabel($dimension['axis']);
            $member = $taxonomy->getElementDataByLabel($dimension['member']);

            $contextEntry->dimension[$i]['axis'] = $axis['_source']['code'];
            $contextEntry->dimension[$i]['member'] =  $member['_source']['code'];
            $i++;
        }

        foreach ($contextEntry->dimension as $dimension){
            $contextEntry->id .= '_' . $dimension['axis'] . '_' . $dimension['member'];
        }

        return $contextEntry;
    }

    function setUnits($unitEntry, $elementType){
        if ($elementType == 'xbrli:monetaryItemType') {
            $unitEntry->id = 'USD';
            $unitEntry->value = 'iso4217:USD';
        } else if($elementType == 'num:perShareItemType'){
            $unitEntry->id = 'UsdPerShare';
            $unitEntry->unitNumerator = 'iso4217:USD';
            $unitEntry->unitDenominator = 'xbrli:shares';
        } else if ($elementType ==  'xbrli:sharesItemType'){
            $unitEntry->id = 'Shares';
            $unitEntry->value = 'xbrli:shares';
            $unitEntry->decimal = 'INF';
        } else if ($elementType ==  'num:percentItemType'){
            $unitEntry->id = 'Pure';
            $unitEntry->value = 'xbrli:pure';
            $unitEntry->decimal = 'INF';
        }
        return $unitEntry;
    }

    function setDateToContext($contextEntry, $data){
        if (isset($data['startdate'])) {//startDate && endDate
            $startDate = DateTime::createFromFormat('F d, Y', $data['startdate'])->format('Y-m-d');
            $endDate = DateTime::createFromFormat('F d, Y', $data['enddate'])->format('Y-m-d');
            $contextEntry->id =  'f_' . $startDate . '_to_' . $endDate;
            $contextEntry->startDate = $startDate;
            $contextEntry->endDate = $endDate;
        } else if (isset($data['instant'])) {//instant
            $period = DateTime::createFromFormat('F d, Y', $data['instant'])->format('Y-m-d');
            $contextEntry->id =  'asOf_' . $period;
            $contextEntry->instant = $period;
        }

        return $contextEntry;
    }
}
