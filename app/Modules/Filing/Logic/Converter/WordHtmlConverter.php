<?php
namespace App\Modules\Filing\Logic\Converter;


use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Writer\HTML;

class WordHtmlConverter {

    private $filingId;
    private $wordFile;
    private $filingPath;
    private $exhibitName;

    public function __construct($filingId, $wordFile, $filingPath, $exhibitName)
    {
        $this->filingId = $filingId;
        $this->wordFile = $wordFile;
        $this->filingPath = $filingPath;
        $this->exhibitName = $exhibitName;
        $this->prepareExhibitName();
    }

    public function convert()
    {
        $exhibits = [];
        $exhibitFilePath = $this->filingPath . '/' . $this->exhibitName . '.html';
        $command = $this->generateConversionCommand();
        exec($command);

        $filePath = public_path('/') . $this->exhibitName . '.html';
        if (file_exists($filePath)){
            exec('mv '. $filePath . ' '. $exhibitFilePath);
            $exhibits['name'] = $this->exhibitName;
            $exhibits['file_path'] = $exhibitFilePath;
        } else {
            $exhibits = [];
            $phpWord = IOFactory::load($this->wordFile);
            $htmlWriter = new HTML($phpWord);
            $exhibitFilePath = $this->filingPath . '/' . $this->exhibitName . '.html';
            $htmlWriter->save($exhibitFilePath);
            $exhibits['name'] = $this->exhibitName;
            $exhibits['file_path'] = $exhibitFilePath;
        }

        return $exhibits;
    }

    function prepareExhibitName(){
        $this->exhibitName = str_replace(' ','-',$this->exhibitName);
    }

    function generateConversionCommand(){
        $command = 'unoconv -f html -t ' . '\'' . $this->wordFile . '\'' . ' -o '. '\''. $this->exhibitName . '\'' . ' ' . '\'' . $this->wordFile . '\'';
        return $command;
    }
}
