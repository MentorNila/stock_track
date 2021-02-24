<?php
namespace App\Modules\Taxonomy\Logic;

use ZipArchive;

class TaxonomyFilesParser {
    private $zipFilePath;
    private $filePath;
    private $preFilesList = [];
    private $fileType;
    private $type;

    public function __construct($zipFilePath, $type = '-pre-', $fileType = 'xml'){
        $this->zipFilePath = $zipFilePath;
        $this->type = $type;
        $this->fileType = $fileType;
        $this->filePath = storage_path('app/public/us-gaap');
        //TODO Find a new way to upload taxonomy
//        $this->unzipFile();
    }

    private function unzipFile(){
        $zip = new ZipArchive;
        $res = $zip->open(storage_path('app/public').'/'.$this->zipFilePath);
        if ($res === TRUE) {
            $zip->extractTo($this->filePath);
            $zip->close();
        }
    }

    public function getFiles($folder){
        $this->listFolderFiles($this->filePath . '/' . $folder);
        return $this->preFilesList;
    }

    function listFolderFiles($dir){
        $ffs = scandir($dir);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        // prevent empty ordered elements
        if (count($ffs) < 1){
            return;
        }

        foreach ($ffs as $ff) {
            if (strpos($ff, $this->type) !== false && strpos($ff, '.' . $this->fileType) !== false) {
                $this->preFilesList[] = $dir . '/' . $ff;
            }

            if (is_dir($dir . '/' . $ff)) {
                $this->listFolderFiles($dir . '/' . $ff);
            }
        }
    }
}
