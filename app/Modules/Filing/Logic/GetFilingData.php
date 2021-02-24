<?php
namespace App\Modules\Filing\Logic;

use App\Modules\Company\Models\Company;
use App\Modules\Filing\Models\Filing;
use App\Modules\Filing\Models\FilingExhibits;
use App\Modules\Filing\Models\FilingFinancialData;

class GetFilingData {

    private $filingId;
    private $filingType;
    private $filingTemplatePath;
    private $company;
    private $data;
    private $endDate;
    private $tables;
    private $status;

    public function __construct($filingId)
    {
        $this->filingId = $filingId;
        $this->setCompany();
        $this->setFilingType();
        $this->setEndDate();
        $this->setStatus();
    }

    private function setFilingType() {
        $this->filingType = Filing::find($this->filingId)->filing_type;
    }

    private function setStatus() {
        $this->status = Filing::find($this->filingId)->status;
    }

    private function setEndDate() {
        $period = $this->getFilingPeriod('Ymd');
        $this->endDate = $period['end_date'];
    }

    private function setCompany(){
        $companyId = Filing::where('id', $this->filingId)->first()->company_id;
        $this->company = Company::select('*','name as company_name','state as state_field')->find($companyId);
    }

    public function generateFilingData(){
        $this->getFilingData();
        foreach ($this->company->toArray() as $key => $item){
            $this->data[$key] = $item;
        }

        return $this->data;
    }

    private function getFilingData(){
        $filingData = Filing::where('id', $this->filingId)->get();
        $this->data = $filingData->groupBy(['source','date'])->toArray();
    }

    public function getFilingType(){
        return $this->filingType;
    }

    public function getEndDate(){
        return $this->endDate;
    }

    public function getCompanyId(){
        return $this->company->id;
    }

    public function getCompany(){
        return $this->company;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getFilingExhibitPaths(){
        $exhibitFiles = FilingExhibits::where('filing_id', $this->filingId)->get()->pluck('exhibit_file_path');
        return $exhibitFiles;
    }
    //Financial Statements
    public function getFilingFSPaths(){
        $fsFilePaths = FilingFinancialData::where('filing_id', $this->filingId)->get()->pluck('fs_file_path');
        return $fsFilePaths;
    }

    public function getFilingExhibitsData(){
        $exhibitFiles = FilingExhibits::where('filing_id', $this->filingId)->get();
        return $exhibitFiles;
    }
    public function getFilingFSData(){
        $fsFiles = FilingFinancialData::where('filing_id', $this->filingId)->get();
        return $fsFiles;
    }

    public function getFilingExhibitByName($name){
        $exhibitFile = FilingExhibits::where('filing_id', $this->filingId)->where('exhibit_name', $name)->first();
        return $exhibitFile;
    }

    public function getFilingPeriod($format = '') {
        $filing = Filing::find($this->filingId);
        $period['start_date'] = null;
        $period['end_date'] = null;

        if($filing->fiscal_year_end_date){
            $date = \Carbon\Carbon::createFromFormat('--m-d', $filing->fiscal_year_end_date)->format('m-d');
            $date = $filing->fiscal_year_focus.'-'.$date;
            $formattedDate = \Carbon\Carbon::createFromFormat('Y-m-d',$date);
            $startDate = date('Y-m-d', strtotime("-12 months +1 day", strtotime($formattedDate)));
            $quarters = [
                'Q1' => [
                    'end_date' => date('Y-m-d', strtotime("+3 months -1 day", strtotime($startDate))),
                ],
                'Q2' => [
                    'end_date' => date('Y-m-d', strtotime("+6 months -1 day", strtotime($startDate)))
                ],
                'Q3' => [
                    'end_date' => date('Y-m-d', strtotime("+9 months -1 day", strtotime($startDate))),
                ],
                'Q4' => [
                    'end_date' => $date
                ],
            ];

            foreach ($quarters as $key => $value) {
                if($key == $filing->fiscal_period_focus){
                    if ($format === ''){
                        $format = 'F d, Y';
                    }
                    $period['start_date'] = \Carbon\Carbon::parse($startDate)->format($format);
                    $period['end_date'] = \Carbon\Carbon::parse($value['end_date'])->format($format);
                }
            }
        }
        return $period;
    }
}
