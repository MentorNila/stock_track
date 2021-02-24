<?php
namespace App\Modules\Fling\Logic\XBRL\EightK\EntryGenerator;

include base_path().'/vendor/autoload.php';

use Sabre\Xml\Service;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class ContextEntry
{

    public $value;
    public $scheme;
    public $id;
    public $startDate;
    public $endDate;
    public $instant;

    function xmlSerialize(\Sabre\Xml\Writer $writer)
    {
        $ns = '{http://www.xbrl.org/2003/instance}xbrli';
        return $writer->writeElement($ns . ':context', function ($writer) use ($ns) {
            $writer->writeAttributes(['id' => $this->id]);
            if (isset($instant)){
                $period = [
                    [
                        'name' => $ns . ":instant",
                        'value' => $this->instant
                    ],
                ];
            } else {
                $period = [
                    [
                        'name' => $ns . ":startDate",
                        'value' => $this->startDate
                    ],
                    [
                        'name' => $ns . ":endDate",
                        'value' => $this->endDate
                    ],
                ];
            }
            $writer->write([
                $ns . ':entity' => [
                    $ns . ':identifier' => [
                        'value' => $this->value,
                        'attributes' => ['scheme' => $this->scheme]
                    ],
                ],
                $ns . ':period' => $period]);
        });
    }

}
