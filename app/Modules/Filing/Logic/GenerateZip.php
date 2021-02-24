<?php
namespace App\Modules\Filing\Logic;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use ZipArchive;

class GenerateZip {
    public $zipFileName;
    private $zipFilePath;
    private $files = [];
    private $extension = 'zip';

    public function __construct($zipFileName, $files = [])
    {
        $this->zipFileName = $zipFileName;
        $this->generateFileName();
        $this->generateFilePath();
        $this->files = $files;
    }

    public function generateZip() {
        $zip = new ZipArchive();
        $zip->open($this->zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach ($this->files as $filename => $filePath){
            $zip->addFile($filePath, $filename);
        }
        $zip->close();
        $this->unlinkZipFiles();

        return $this->zipFilePath;
    }

    private function unlinkZipFiles(){
        foreach ($this->files as $filePath){
            unlink($filePath);
        }
    }

    private function generateFileName(){
        $date = Carbon::now();
        $date = $date->format('Ymd-Hms');
        $this->zipFileName = $this->zipFileName . $date . '.'. $this->extension;
    }

    private function generateFilePath(){
        $this->zipFilePath = storage_path('app/public/'. $this->zipFileName);
    }
}
