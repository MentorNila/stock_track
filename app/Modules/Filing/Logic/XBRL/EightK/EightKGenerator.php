<?php

namespace App\Modules\Filing\Logic\XBRL\EightK;

include base_path().'/vendor/autoload.php';

use App\Modules\Fling\Logic\XBRL\EightK\EntryGenerator\DeiEntry;
use Illuminate\Support\Facades\File;
use Sabre\Xml\Service;

class EightKGenerator {
    public function __construct()
    {

    }
    public function generateXml($filingId = 1 , $filing = [], $deiEntries = [], $contextEntry = []){
        $service = new Service();
        $ns = '{http://www.xbrl.org/2003/instance}xbrli';

        $service->namespaceMap['http://www.xbrl.org/2003/instance'] = '';

        $rootAttributes = ['xmlns:xsi'=>'http://www.w3.org/2001/XMLSchema-instance','xmlns:xlink'=>'http://www.w3.org/1999/xlink','xmlns:link'=>'http://www.xbrl.org/2003/linkbase',
            'xmlns:xbrli'=>'http://www.xbrl.org/2003/instance','xmlns:xbrldt'=>'http://xbrl.org/2005/xbrldt','xmlns:xbrldi'=>'http://xbrl.org/2006/xbrldi','xmlns:dei'=>'http://xbrl.sec.gov/dei/2018-01-31',
            'xmlns:ref'=>'http://www.xbrl.org/2006/ref','xmlns:iso4217'=>'http://www.xbrl.org/2003/iso4217','xmlns:us-gaap'=>'http://fasb.org/us-gaap/2018-01-31','xmlns:us-roles'=>'http://fasb.org/us-roles/2018-01-31',
            'xmlns:nonnum'=>'http://www.xbrl.org/dtr/type/non-numeric','xmlns:num'=>'http://www.xbrl.org/dtr/type/numeric','xmlns:us-types'=>'http://fasb.org/us-types/2018-01-31','xmlns:country'=>'http://xbrl.sec.gov/country/2017-01-31',
            'xmlns:currency'=>'http://xbrl.sec.gov/currency/2017-01-31','xmlns:exch'=>'http://xbrl.sec.gov/exch/2018-01-31','xmlns:invest'=>'http://xbrl.sec.gov/invest/2013-01-31','xmlns:naics'=>'http://xbrl.sec.gov/naics/2017-01-31',
            'xmlns:sic'=>'http://xbrl.sec.gov/sic/2011-01-31','xmlns:stpr'=>'http://xbrl.sec.gov/stpr/2018-01-31','xmlns:mddt'=>'http://mdco.com/20180331'];

        $wr = ($service->write('xbrli:xbrl', function ($writer) use ($rootAttributes, $deiEntries, $contextEntry) {

            $writer->writeAttributes($rootAttributes);

            $contextEntry->xmlSerialize($writer);


            foreach ($deiEntries as $deiEntry) {
                $dE = new DeiEntry();
                $dE->name = $deiEntry['name'];
                $dE->attributes = $deiEntry['attributes'];
                $dE->value = $deiEntry['value'];
                $dE->xmlSerialize($writer);
            }
        }));


        $xmlFileName = '8_K.xml';
        $xmlFilePath = storage_path($xmlFileName);
        File::put($xmlFilePath, /*(string)htmlspecialchars_decode*/($wr));

        return [$xmlFileName => $xmlFilePath];
    }
}
