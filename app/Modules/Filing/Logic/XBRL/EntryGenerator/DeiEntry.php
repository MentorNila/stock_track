<?php
namespace App\Modules\Filing\Logic\XBRL\EntryGenerator;

include base_path().'/vendor/autoload.php';

use Sabre\Xml\Writer;

class DeiEntry
{
    public $name;
    public $value;
    public $attributes = [];

    public function xmlSerialize(Writer $writer)
    {
        return $writer->writeElement($this->name, function ($writer) {
            $this->removeSpacesFromContent();
            $writer->writeAttributes($this->attributes);
            $writer->write(trim($this->value));
        });
    }

    public function removeSpacesFromContent(){
        $this->value = str_replace("\n","", $this->value);
        $this->value = str_replace("\t","", $this->value);
        $this->value = str_replace("&nbsp;","", $this->value);
    }
}
