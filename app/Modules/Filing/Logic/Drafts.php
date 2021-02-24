<?php
namespace App\Modules\Filing\Logic;

class Drafts {
    private $filingId;
    private $content;
    private $companyId;
    private $filingType;
    private $filingPath;

    public function __construct($filingId, $content) {
        $this->filingId = $filingId;
        $this->content = $content;
        $this->getFilingInfo();
    }

    private function getFilingInfo(){
        $filingData = new GetFilingData($this->filingId);
        $this->companyId = $filingData->getCompanyId();
        $this->filingType = $filingData->getFilingType();
    }

    public function storeAsDraft(){
        $this->getFilingDraftPath();
        file_put_contents($this->filingPath . '/draft.html', $this->content);
    }

    public function storeExhibitAsDraft($fileName){
      $this->getExhibitDraftPath();
      file_put_contents($this->filingPath . '/'.$fileName.'.html', $this->content);
    }

    private function getFilingDraftPath(){
        $this->filingPath = StorageHelper::getFilingDraftPath($this->companyId, $this->filingId);
    }

    private function getExhibitDraftPath(){
      $this->filingPath = StorageHelper::getExhibitDraftPath($this->companyId, $this->filingId);
    }


}
