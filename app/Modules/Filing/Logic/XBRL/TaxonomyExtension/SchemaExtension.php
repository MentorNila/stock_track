<?php

namespace App\Modules\Filing\Logic\XBRL\TaxonomyExtension;

use App\Modules\Filing\Logic\XBRL\EntryGenerator\AnnotationEntry;
use App\Modules\Taxonomy\Logic\Taxonomy;
use Illuminate\Support\Facades\File;
use Sabre\Xml\Service;

include base_path().'/vendor/autoload.php';


class SchemaExtension extends TaxonomyExtension {
    private $service;
    private $writer;
    public $filingId;
    private $importEntries = [];
    private $elements = [];
    private $appInfo;
    private $sections;

    public function __construct($sections, $filingId)
    {
        $this->sections = $sections;
        $this->filingId = $filingId;
        parent::__construct();
        $this->service = new Service();
        $this->generateImportEntries();
        $this->generateAppInfo($this->company->name);
    }

    public function generateSchema(){
        $ns = '{http://www.w3.org/2001/XMLSchema}xsd';
        $this->service->namespaceMap['http://www.w3.org/2001/XMLSchema'] = '';

        $rootAttributes = $this->generateRootAttributes();

        $this->writer = ($this->service->write($ns.':schema', function ($writer) use ($rootAttributes, $ns) {
            $writer->writeAttributes($rootAttributes);
            if (!empty($this->importEntries)) {
                foreach ($this->importEntries as $importEntry) {
                    if ($importEntry !== '') {
                        $writer->writeElement($ns . ':import', function ($writer) use ($importEntry) {
                            $writer->writeAttributes(['namespace' => $importEntry, 'schemaLocation' => $this->getNamespaceHref($importEntry)]);
                        });
                    }
                }
            }
            $annotationEntry = new AnnotationEntry($this->appInfo, $this->sections, $this->company->uri);
            $annotationEntry->xmlSerialize($writer);
            if (!empty($this->elements)) {
                foreach ($this->elements as $attr => $element) {
                    $writer->writeElement($ns . ':element', function ($writer) use ($element) {
                        unset($element['_source']['label']);
                        unset($element['_source']['documentation']);
                        unset($element['_source']['code']);
                        unset($element['_source']['namespace']);
                        foreach ($element['_source'] as $key => $item) {
                            if ($item !== ''){
                                $writer->writeAttribute($key, $item);
                            }
                        }
                    });
                }
            }
        }));

        $xmlFileName = $this->schemaFileName;
        $xmlFilePath = storage_path($xmlFileName);
        File::put($xmlFilePath, $this->writer);

        return [$xmlFileName => $xmlFilePath];
    }

    public function generateImportEntries(){
        $taxonomy = new Taxonomy();
        foreach ($this->sections as $section){
            if (isset($section['tags']) && !empty($section['tags'])){
                foreach ($section['tags'] as $item){
                    if (!is_null($item['attributes']['tag'])){
                        $tag = $taxonomy->getElementDataByLabel($item['attributes']['tag'], true);
                        $companySymbol = $this->company->symbol.'_';
                        if (substr($tag['_source']['code'], 0, strlen($companySymbol)) === $companySymbol){
                            $this->elements[] = $tag;
                        }
                        if (!empty($item['attributes']['dimensions'])){
                            foreach ($item['attributes']['dimensions'] as $key) {
                                $axis = $taxonomy->getElementDataByLabel($key['axis'], true);

                                if (substr($axis['_source']['code'], 0, strlen($companySymbol)) === $companySymbol){
                                    $this->elements[] = $axis;
                                }
                                $member = $taxonomy->getElementDataByLabel($key['member'], true);

                                if (substr($member['_source']['code'], 0, strlen($companySymbol)) === $companySymbol){
                                    $this->elements[] = $member;
                                }
                            }
                        }
                        if (!is_null($tag) && !in_array($tag['_source']['namespace'], $this->importEntries)){
                            $this->importEntries[] = $tag['_source']['namespace'];
                        }
                    }

                }
            }
        }
    }


    public function generateAppInfo($name){
        $this->appInfo['calculation'] = $this->calFileName;
        $this->appInfo['definition'] = $this->defFileName;
        $this->appInfo['label'] = $this->labFileName;
        $this->appInfo['presentation'] = $this->preFileName;
        $this->appInfo['xlink:type'] = 'simple';
    }

    public function generateRootAttributes(){
        $rootAttributes = [
            'xmlns:xlink'=>'http://www.w3.org/1999/xlink',
            'xmlns:link'=>'http://www.xbrl.org/2003/linkbase',
            'xmlns:xbrli'=>'http://www.xbrl.org/2003/instance',
            'xmlns:xbrldt'=>'http://xbrl.org/2005/xbrldt',
            'xmlns:nonnum'=>'http://www.xbrl.org/dtr/type/non-numeric',
            'xmlns:xsd'=>'http://www.w3.org/2001/XMLSchema',
            'attributeFormDefault'=>'unqualified',
            'elementFormDefault'=>'qualified',
            'targetNamespace'=>$this->company->uri.$this->endDate,
        ];

        return $rootAttributes;
    }

}
