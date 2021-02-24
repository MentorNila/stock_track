<?php

namespace App\Modules\Filing\Logic;

use App\Modules\Company\Models\Company;
use App\Modules\Filing\Models\Filing;
use App\Modules\Filing\Models\FilingExhibits;

class GenerateExhibits {
    private $filingId;
    private $filingType;
    private $client;

    public function __construct($filingId)
    {
        $this->filingId = $filingId;
        $this->setFilingType();
        $this->setClient();
    }

    private function setFilingType() {
        $this->filingType = Filing::find($this->filingId)->filing_type;
    }

    private function setClient(){
        $company = Filing::find($this->filingId)->company_id;
        $this->client = Company::select('*','name as company_name','state as state_field')->find($company);
    }

    public function generateExhibits()
    {
        $exhibitFiles = [];
        $exhibits = FilingExhibits::where('filing_id', $this->filingId)->get();
        foreach ($exhibits as $exhibit) {
            $exhibitFiles[$exhibit->exhibit_name . '.html'] = storage_path() . '/' . $exhibit->exhibit_name . '.html';
           copy($exhibit->exhibit_file_path, storage_path().'/'.$exhibit->exhibit_name.'.html');
        }
        return $exhibitFiles;
    }
}
