<?php
namespace App\Modules\Filing\Logic\XBRL\TaxonomyExtension;

use App\Modules\Filing\Logic\GetFilingData;
use App\Modules\Taxonomy\Logic\Taxonomy;
use Elasticsearch\ClientBuilder;

abstract class TaxonomyExtension {

    public $schemaFileName;
    public $calFileName;
    public $preFileName;
    public $defFileName;
    public $labFileName;
    public $company;
    public $endDate;
    public $taxonomy;

    function __construct()
    {
        $this->taxonomy = new Taxonomy();
        $this->setCompany();
        $this->getEndDate();
        $this->generateFileNames();
    }

    function generateFileNames(){
        $this->schemaFileName  = $this->company->symbol.'-'.$this->endDate.'.xsd';
        $this->calFileName = $this->company->symbol.'-'.$this->endDate.'_cal.xml';
        $this->preFileName = $this->company->symbol.'-'.$this->endDate.'_pre.xml';
        $this->defFileName = $this->company->symbol.'-'.$this->endDate.'_def.xml';
        $this->labFileName = $this->company->symbol.'-'.$this->endDate.'_lab.xml';
    }

    public function setCompany(){
        $filingData = new GetFilingData($this->filingId);
        $this->company = $filingData->getCompany();
    }

    public function getEndDate(){
        $filingData = new GetFilingData($this->filingId);
        $this->endDate = $filingData->getEndDate();
        $this->endDate = str_replace('-', '', $this->endDate);
    }


    function checkIfElementIsUsed(&$usedItem, $tag){
        if (empty($usedItem)){
            return false;
        }
        foreach ($usedItem as &$item){
            if ($tag === $item['code']){
                $item['order'] = $item['order'] + 1;
                return true;
            }
        }

        return false;
    }
    function getNamespaceHref($namespace){
        $namespaces = [
          'http://xbrl.fasb.org/srt/2018/elts/srt-2018-01-31.xsd',
          'http://xbrl.fasb.org/us-gaap/2018/elts/us-gaap-2018-01-31.xsd',
          'https://xbrl.sec.gov/dei/2018/dei-2018-01-31.xsd',
          'https://xbrl.sec.gov/invest/2013/invest-2013-01-31.xsd',
          'https://xbrl.sec.gov/country/2018/country-2018-01-31.xsd',
          'https://xbrl.sec.gov/currency/2018/currency-2018-01-31.xsd',
          'http://xbrl.fasb.org/dei/2018/elts/dei-2018-01-31.xsd',

          'http://xbrl.fasb.org/srt/2019/elts/srt-2019-01-31.xsd',
          'http://xbrl.fasb.org/us-gaap/2019/elts/us-gaap-2019-01-31.xsd',
          'https://xbrl.sec.gov/dei/2019/dei-2019-01-31.xsd',
          'https://xbrl.sec.gov/country/2017/country-2017-01-31.xsd',
          'https://xbrl.sec.gov/currency/2017/currency-2017-01-31.xsd',
          'https://xbrl.sec.gov/dei/2019/dei-2019-01-31.xsd',
        ];
        //TODO
        /*$data = explode('/', $namespace);
        $year = $data[count($data) - 1];
        $type = $data[count($data) - 2];
        foreach ($namespaces as $item){
            if (Str::contains($item, $year) && Str::contains($item, $type)) {
                return $item;
            }
        }*/
        return $namespace;

    }
    function getOrder($usedItems, $tag){
        foreach ($usedItems as $item){
            if ($tag === $item['code']){
                return $item['order'];
            }
        }
        return '0';
    }

    function checkForCalculationTags($tags){
        foreach ($tags as $key => $tag){
            if (!isset($tag['attributes']['sum']) || is_null($tag['attributes']['sum'])){
                unset($tags[$key]);
            }
        }
        return $tags;
    }

    public function getTaxonomyElement(){
        foreach ($this->sections as $section){
            foreach ($section['tags'] as $item){
                $tag = $this->taxonomy->getElementDataByLabel($item['attributes']['tag']);
                if ($tag){
                    if (isset($item['attributes']['labels'])){
                        $tag['labels'] = $item['attributes']['labels'];
                    }
                    $this->elements[] = $tag;
                }
            }

        }
    }
}
