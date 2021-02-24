<?php
namespace App\Modules\Taxonomy\Logic;


use App\Modules\Taxonomy\Models\ElementRelation;
use App\Modules\Taxonomy\Models\TaxonomyElement;
use Illuminate\Support\Facades\Storage;
use Mtownsend\XmlToArray\XmlToArray;

class UnusedTaxonomy {
    private $data;
    private $year;
    private $preFileName = '';
    private $taxonomyData;
    private $presentationData;
    private $elements = [];
    private $elementRelation = [];
    private $definitionData;
    private $labelData;

    public function __construct($presentationData, $year) {
        $this->presentationData = $presentationData;
        $this->year = $year;
        $this->getTaxonomyFiles();
        //$this->storeTaxonomy();
    }

    public function loadTaxonomy(){
        return $this->elements;
    }

    public function addElementsDefinition(){
        $this->getDefinitionData();
        foreach ($this->definitionData as $data){
            foreach ($data['link:labelLink']['link:label'] as $definitionDatum) {
                $content = $definitionDatum['@content'];
                if (isset($definitionDatum['@attributes']) && isset($definitionDatum['@attributes']['label'])){
                    $label = $definitionDatum['@attributes']['label'];
                    $name = explode('_', $label)[1];
                    TaxonomyElement::where('name', trim($name))->update(['documentation' => $content]);
                }
            }
        }

    }
    public function addElementsLabel() {
        $this->getLabelData();
        foreach ($this->labelData as $data) {
            foreach ($data['link:labelLink']['link:label'] as $definitionDatum) {
                $content = $definitionDatum['@content'];
                if (isset($definitionDatum['@attributes']) && isset($definitionDatum['@attributes']['label'])) {
                    $label = $definitionDatum['@attributes']['label'];
                    $name = explode('_', $label)[1];
                    TaxonomyElement::where('name', trim($name))->update(['label' => $content]);
                }
            }
        }
    }

    public function applyPresentationStructure(){
        foreach ($this->presentationData as $preData){
            $this->preFileName = basename($preData,'.xml');
            $xml = file_get_contents($preData);
            $this->data = XmlToArray::convert($xml);
            $this->setRelations();
        }
    }

    private function setRelations() {
        foreach ($this->data['link:presentationLink'] as $key => $data) {
            if (is_int($key)) {
                foreach ($data as $key1 => $item) {
                    if ($key1 === 'link:loc') {
                        $this->getElements($item);
                    } else if ($key1 === 'link:presentationArc') {
                        $this->getElementsRelations($item);
                    }
                }
                $this->setElementRelations();
                $this->elementRelation = [];
                $this->elements = [];
            } else {
                if ($key === 'link:loc') {
                    $this->getElements($data);
                } else if ($key === 'link:presentationArc') {
                    $this->getElementsRelations($data);
                }
            }
        }
        $this->setElementRelations();
        $this->elements = [];
        $this->elementRelation = [];
    }

    private function getElements($data){
        $i = 0;
        foreach ($data as $key => $loc) {
            foreach ($loc as $attributes => $item) {
                $elementId = parse_url($item['href']);
                $i++;
                $this->elements[$i]['code'] = $item['label'];
                $this->elements[$i]['id'] = $elementId['fragment'];
            }
        }
    }

    private function getElementsRelations($data){
        $i = 0;
        foreach ($data as $key => $presentationArc) {
            if($key === '@attributes'){
                $this->elementRelation[$i]['order'] = $presentationArc['order'];
                $this->elementRelation[$i]['from'] = $presentationArc['from'];
                $this->elementRelation[$i]['to'] = $presentationArc['to'];
                $this->elementRelation[$i]['type'] = $presentationArc['type'];

                $i++;
            } else {
                foreach ($presentationArc as $attributes => $item) {
                    $this->elementRelation[$i]['order'] = $item['order'];
                    $this->elementRelation[$i]['from'] = $item['from'];
                    $this->elementRelation[$i]['to'] = $item['to'];
                    $this->elementRelation[$i]['type'] = $item['type'];
                    $i++;
                }
            }
        }
    }

    private function setElementRelations(){
        foreach ($this->elementRelation as $relation){
            $parentChildRelation = $this->findElementRelation($relation['from'], $relation['to']);
            $parent = TaxonomyElement::where('code', $parentChildRelation['parent'])->first();
            $child = TaxonomyElement::where('code', $parentChildRelation['child'])->first();
            if ($parent && $child){
                $el = ElementRelation::where('element_id',$child->id)->where('parent_id', $parent->id)->where('file_name',$this->preFileName)->get();
                if (count($el) === 0) {
                    $elementRelation = new ElementRelation();
                    $elementRelation->store($child->id, $parent->id, $this->preFileName);
                }
            }
        }
        return $this->elements;
    }

    private function findElementRelation($parent, $child){
        $parentId = 0;
        foreach ($this->elements as $code => $item){
            if ($parent === $item['code']){
                $parentId = $item['id'];
            } else if ($child === $item['code']){
                $child = $item['id'];
            }
        }
        return ['parent' => $parentId, 'child' => $child];
    }

    public function storeTaxonomy(){
        foreach ($this->taxonomyData as $item) {
            if (!empty($item)) {
                $targetNamespace = null;
                if (isset($item['@attributes']) && isset($item['@attributes']['targetNamespace'])){
                    $targetNamespace = $item['@attributes']['targetNamespace'];
                }
                foreach ($item['xs:element'] as $element) {
                    foreach ($element as $key => $attributes) {
                        $taxonomyElement = new TaxonomyElement();
                        $attributes['code'] = $attributes['id'];
                        unset($attributes['id']);
                        $attributes['namespace'] = $targetNamespace;
                        $taxonomyElement->store($attributes);
                    }
                }
            }
        }
    }

    public function getTaxonomyFiles(){
        $taxFile = Storage::disk('taxonomy')->get($this->year . '/srt-' . $this->year . '-01-31.xsd');
        $this->taxonomyData[] = XmlToArray::convert($taxFile);

        $taxFile = Storage::disk('taxonomy')->get($this->year . '/us-gaap-' . $this->year . '-01-31.xsd');
        $this->taxonomyData[] = XmlToArray::convert($taxFile);

        $taxFile = Storage::disk('taxonomy')->get($this->year . '/dei-' . $this->year . '-01-31.xsd');
        $this->taxonomyData[] = XmlToArray::convert($taxFile);

        $investFilePath = storage_path('app/taxonomy/').$this->year.'/invest-2013-01-31.xsd';
        if (file_exists($investFilePath)){
            $taxFile = Storage::disk('taxonomy')->get($this->year . '/invest-2013-01-31.xsd');
            $this->taxonomyData[] = XmlToArray::convert($taxFile);
        }
        $countryFilePath = storage_path('app/taxonomy/').$this->year.'/country-2017-01-31.xsd';
        if (file_exists($countryFilePath)){
            $taxFile = Storage::disk('taxonomy')->get($this->year . '/country-2017-01-31.xsd');
            $this->taxonomyData[] = XmlToArray::convert($taxFile);
        }
        $currencyFilePath = storage_path('app/taxonomy/').$this->year.'/currency-2017-01-31.xsd';
        if (file_exists($currencyFilePath)){
            $taxFile = Storage::disk('taxonomy')->get($this->year . '/currency-2017-01-31.xsd');
            $this->taxonomyData[] = XmlToArray::convert($taxFile);
        }

        return $this->taxonomyData;
    }

    private function getDefinitionData(){
        $deiDoc = Storage::disk('taxonomy')->get($this->year . '/dei-doc-' . $this->year . '-01-31.xml');
        $this->definitionData[] = XmlToArray::convert($deiDoc);
        $usGaapDoc = Storage::disk('taxonomy')->get($this->year . '/us-gaap-doc-' . $this->year . '-01-31.xml');
        $this->definitionData[] = XmlToArray::convert($usGaapDoc);
        $srtDoc = Storage::disk('taxonomy')->get($this->year . '/srt-doc-' . $this->year . '-01-31.xml');
        $this->definitionData[] = XmlToArray::convert($srtDoc);
    }

    private function getLabelData(){
        $deiLab = Storage::disk('taxonomy')->get($this->year . '/dei-lab-' . $this->year . '-01-31.xml');
        $this->labelData[] = XmlToArray::convert($deiLab);

        $usGaapLab = Storage::disk('taxonomy')->get($this->year . '/us-gaap-lab-' . $this->year . '-01-31.xml');
        $this->labelData[] = XmlToArray::convert($usGaapLab);

        $srtLab = Storage::disk('taxonomy')->get($this->year . '/srt-lab-' . $this->year . '-01-31.xml');
        $this->labelData[] = XmlToArray::convert($srtLab);
    }
}
