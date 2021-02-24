<?php
namespace App\Modules\Fling\Logic\XBRL\EightK\EntryGenerator;

include base_path().'/vendor/autoload.php';

use Sabre\Xml\Writer;

class DeiEntry
{
    public $name;
    public $value;
    public $attributes = [];

    public function xmlSerialize(Writer $writer)
    {
        //$ns = '{http://www.xbrl.org/2003/instance}dei';
        return $writer->writeElement($this->name, function ($writer) {
            $this->removeSpacesFromContent();
            $writer->writeAttributes($this->attributes);
            $writer->write($this->value);
        });
    }

    public function removeSpacesFromContent(){
        $this->value = str_replace("\n","", $this->value);
        $this->value = str_replace("\t","", $this->value);
        $this->value = str_replace("&nbsp;","", $this->value);
    }

    public function generateDeiEntry($data){
        $deiEntries[] = [
            [
            'name' => 'DocumentType',
            'attributes' => ['id'=>'F_00000', 'contextRef' => 'C_0001680581_20190101_20190630'],
            'value' => '8-K'
            ]
        ];
    }
}
