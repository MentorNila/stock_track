<?php
namespace App\Modules\Filing\Logic\XBRL\EntryGenerator;

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
    public $dimension;

    function xmlSerialize(\Sabre\Xml\Writer $writer)
    {
        $ns = '{http://www.xbrl.org/2003/instance}';
        return $writer->writeElement($ns . 'context', function ($writer) use ($ns) {
            $writer->writeAttributes(['id' => $this->id]);
            if (isset($this->instant)){
                $period = [
                    [
                        'name' => $ns . "instant",
                        'value' => $this->instant
                    ],
                ];
            } else {
                $period = [
                    [
                        'name' => $ns . "startDate",
                        'value' => $this->startDate
                    ],
                    [
                        'name' => $ns . "endDate",
                        'value' => $this->endDate
                    ],
                ];
            }
            $contextEntry[$ns . 'entity'][$ns . 'identifier'] = [
                'value' => $this->value,
                'attributes' => ['scheme' => $this->scheme]
            ];
            if (isset($this->dimension) && !empty($this->dimension)){
                foreach ($this->dimension as $dimension) {
                    if (isset($dimension['axis']) && isset($dimension['member'])){
                        $contextEntry[$ns . 'entity'][$ns . 'segment'][] = [
                            $ns . 'explicitMember' => [
                                'value' => $dimension['member'],
                                'attributes' => ['dimension' => $dimension['axis']]
                            ]
                        ];
                    }
                }
            }
            $contextEntry[$ns . 'period'] = $period;

            $writer->write($contextEntry);
        });
    }

}
