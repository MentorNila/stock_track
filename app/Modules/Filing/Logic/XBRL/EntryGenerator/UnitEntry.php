<?php
namespace App\Modules\Filing\Logic\XBRL\EntryGenerator;

include base_path().'/vendor/autoload.php';

use Sabre\Xml\Writer;

class UnitEntry
{
    public $value;
    public $id;
    public $unitNumerator;
    public $unitDenominator;
    public $decimal;

    function xmlSerialize(Writer $writer)
    {
        $ns = '{http://www.xbrl.org/2003/instance}';
        return $writer->writeElement($ns . 'unit', function ($writer) use ($ns) {
            $writer->writeAttributes(['id' => $this->id]);
            if (isset($this->value)){
                $writer->write([
                    $ns . 'measure' => $this->value,
                ]);
            } else {
                $writer->write([
                    $ns . 'divide' => [
                        $ns . 'unitNumerator' => [
                            $ns . 'measure' => $this->unitNumerator
                        ],
                        $ns . 'unitDenominator' => [
                            $ns . 'measure' => $this->unitDenominator
                        ]
                    ]
                ]);
            }
        });
    }
}
