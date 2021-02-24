<?php
namespace App\Modules\Editor\Logic;

use App\Modules\Client\Models\Client;
use App\Modules\Filing\Logic\GetFilingData;
use App\Modules\Filing\Logic\StorageHelper;
use App\Modules\Filing\Models\Filing;
use Illuminate\Support\Facades\Date;
use DB;

class Editor {

    private $filingId;
    private $filingType;
    private $startDate;
    private $endDate;

    public function __construct($filingId)
    {
        $this->filingId = $filingId;
        $this->checkFiling();
        $this->setFilingType();
        $this->setStartDate();
        $this->setEndDate();
    }
    /**
     * Method to check if filing exists
     * */
    private function checkFiling(){
        $companyFiling = Filing::where('id', $this->filingId)->first();
        if(!$companyFiling) {
            abort(404);
        }
    }

    /** Method to prepare filing content for edit
     * @return string
     */
    public function getExhibits(){
        $filingData = new GetFilingData($this->filingId);
        $exhibitsData = [];
        $filingExhibits = $filingData->getFilingExhibitsData();
        foreach ($filingExhibits as $item){
            $exhibitsData[$item->exhibit_name] = $item->exhibit_description;
        }
        return $exhibitsData;
    }
    public function getFilingContent()
    {
        $filingData = new GetFilingData($this->filingId);

        $companyId = $filingData->getCompanyId();
        try {
            $filing = $filingData->generateFilingData();
        } catch (\Exception $ex) {
            Filing::where('id', $this->filingId)->delete();
            return \Redirect::route('generate-filing.index', ['client_id' => $companyId])->withError('Error while uploading data, please try again');
        }
        //F is for month e.g. September
        $filing['today_date'] = Date::now()->format('F d, Y');
        $filing['start_date'] = \Carbon\Carbon::parse($this->startDate)->format('F d, Y');
        $filing['end_date'] = \Carbon\Carbon::parse($this->endDate)->format('F d, Y');

        $fsData = [];
        $filingFS = $filingData->getFilingFSData();
        if (!empty($filingFS)) {
            foreach ($filingFS as $item) {
                $fsContent = file_get_contents($item->fs_file_path);
                $fsData[$item->fs_type] = $fsContent;
            }
        }

        $exhibitsData = [];
        $filingExhibits = $filingData->getFilingExhibitsData();
        foreach ($filingExhibits as $item){
            $exhibitsData[$item->exhibit_name] = $item->exhibit_description;
        }

        $client = Client::getCurrentClientId();
        $htmlDocumentPath = StorageHelper::getHtmlDocumentPath($client, $this->filingId);
        $path = $htmlDocumentPath. '/test.blade.php';
        if(!file_exists($path)){
            return (string)view('Form::templates.' . $this->filingType)->with($filing)->with($fsData)->with([
                'filingId' => $this->filingId,
                'filingType' => $this->filingType,
                'exhibits' => $exhibitsData
            ]);
        }
        return view()->file($path)->with(['fsData' => $fsData, 'exhibits' => $exhibitsData, 'filingId' => $this->filingId]);
    }

    private function setFilingType() {
        $this->filingType = Filing::find($this->filingId)->filing_type;
    }

    private function setStartDate() {
        $this->startDate = null;
    }

    private function setEndDate() {
        $this->endDate = null;
    }

    public function getFilingType(){
      return $this->filingType;
    }

    public function getStartDate(){
      return $this->startDate;
    }

    public function getEndDate(){
      return $this->endDate;
    }
}
