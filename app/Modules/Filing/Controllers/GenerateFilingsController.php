<?php

namespace App\Modules\Filing\Controllers;

use App\Modules\Company\Logic\CompanyLogic;
use App\Modules\Company\Models\Company;
use App\Modules\Editor\Logic\Editor;
use App\Modules\Filing\Logic\Drafts;
use App\Modules\Filing\Logic\Converter\ExcelHtmlConverter;
use App\Modules\Filing\Logic\Converter\WordHtmlConverter;
use App\Modules\Filing\Logic\Converter\WordHtml;
use App\Modules\Filing\Logic\GenerateExhibits;
use App\Modules\Filing\Logic\GenerateZip;
use App\Modules\Filing\Logic\GetFilingData;
use App\Modules\Filing\Logic\StorageHelper;
use App\Modules\Filing\Logic\Tags;
use App\Modules\Filing\Logic\XBRL\FormThreeGenerator;
use App\Modules\Filing\Logic\XBRL\FormDGenerator;
use App\Modules\Filing\Logic\XBRL\XBRLGenerator;
use App\Modules\Filing\Models\FilingFinancialData;
use App\Modules\Filing\Models\FilingExhibits;
use App\Modules\Filing\Models\Filing;
use App\Http\Controllers\Controller;
use App\Modules\Filing\Requests\MassDestroyGenerateFilingDataRequest;
use App\Modules\Filing\XBRL\FormFiveGenerator;
use App\Modules\Filing\Logic\XBRL\Form13FHRGenerator;
use App\Modules\Filing\XBRL\FormFourGenerator;
use App\Modules\Form\Models\Exhibits;
use App\Modules\Form\Models\FormExhibits;
use App\Modules\Form\Models\Forms;
use App\Modules\Plans\Models\PlanForm;
use App\Modules\Client\Models\Client;
use App\Modules\Plans\Models\Plan;
use App\Modules\User\Models\UserCompany;
use Carbon\Carbon;
use finfo;
use Gate;
use Auth;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class GenerateFilingsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('filing_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $exhibits = Exhibits::all();

        $plan_id = Client::where('id', Client::getCurrentClientId())->first()->plan_id;
        $forms = PlanForm::join('forms', 'forms.id', '=', 'form_id')->where('plan_id', $plan_id)->where('is_active', 1)->get();
        $todayDate = \Carbon\Carbon::now()->format('F d, Y');
        $companies = (new CompanyLogic)->getCompanies();


//             Plan::insert([
//                 'id' => 1,
//                 'title' => 'First Plan',
//                 'company_number' => 1,
//                 'description' => 'description',
//                 'price' => 50
//             ]);
//             Company::create([
//                 'name' => 'First Company'
//             ]);
//
//             $allForms = Forms::get();
//             foreach($allForms as $current) {
//                 PlanForm::insert([
//                     'plan_id' => 1,
//                     'form_id' => $current->id,
//                     'price_per_page' => '25',
//                     'price_per_form' => '50',
//                     'is_active' => 1
//                 ]);
//             }
//             UserCompany::create([
//                 'user_id' => 1,
//                 'company_id' => 1
//             ]);
        return view('Form::chooseForm')->with(['exhibits' => $exhibits, 'forms' => $forms, 'todayDate' => $todayDate, 'companies' => $companies]);
    }

    public function getExhibits(){
        $request = \Request::all();
        if (isset($request['formType']) && $request['formType'] != '') {
            $formType = $request['formType'];
            $form = Forms::where('type', $formType)->first();
            $form_id = $form->id;
            $exhibits = FormExhibits::where('form_id', $form_id)->with('exhibit')->get();
            return $exhibits;
        }
    }

    public function uploadData(){
        abort_if(Gate::denies('filing_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request = \Request::all();
        $companyId = $request['companyId'];
        $formType = $request['formType'];
        $todayDate = \Carbon\Carbon::now()->format('Y-m-d');
        $todayDateFiscal = \Carbon\Carbon::now()->format('--m-d');
        $currentYear = \Carbon\Carbon::now()->year;
        $financialStatements = false;

        if($formType === '10Q') {
            $financialStatements = true;
        }
        $view = (string)view('Form::statements-exhibits-partial')->with(['companyId' => $companyId, 'formType' => $formType, 'financialStatements'=> $financialStatements, 'todayDate' => $todayDate, 'currentYear' => $currentYear, 'todayDateFiscal' => $todayDateFiscal]);
        $url = null;
        if(in_array($formType, ['Form3','Form4','Form5','FormD','13FHR','DEF14A'], true )){
            $filing = $this->storeFiling(['form_type' => $formType, 'company_id' => $companyId]);
            $filingId = $filing['filingId'];
            $url = route('editor.edit-content', $filingId);
        }

        return \Response::json(array(
            'success'=> true,
            'view' => $view,
            'url' => $url,
        ), 200);

    }

    public function storeFiling($request){
        $filing = new Filing();
        $formType = $request['form_type'];
        if (isset($request['filing'])){
            if (isset($request['filing']['amendment_flag']) && $request['filing']['amendment_flag'] == 'on'){
                $request['filing']['amendment_flag'] = 1;
            } else {
                $request['filing']['amendment_flag'] = 0;
            }
            $request['filing']['filing_type'] = $formType;
            $request['filing']['status'] = 'idle';
            $request['filing']['company_id'] = $request['company_id'];

            $filing = $filing->store($request['filing']);
        } else {
            $data['filing_type'] = $formType;
            $data['status'] = 'idle';
            $data['company_id'] = $request['company_id'];
            $filing = $filing->store($data);
        }

        $filingId = $filing->id;
        $sheetNames = null;

        if (isset($request['sheet-name'])){
            $sheetNames = $request['sheet-name'];
        }

        $companyId = $request['company_id'];

        $date = Carbon::now();
        $date = $date->format('Ymd-Hms');

        $exhibitsIncluded = false;
        $fsIncluded = false;
        $wordDocumentIncluded = false;
        $clientId = Client::getCurrentClientId();
        try {
            $storagePath = StorageHelper::getFilingSheetPath($companyId, $filingId);
            $financialStatementsPath = StorageHelper::getFinancialStatementsPath($companyId, $filingId);
            if (isset($request['excel_sheets']) && !empty($request['excel_sheets'])){
                foreach ($request['excel_sheets'] as $excel){
                    $fullFileName = $excel->getClientOriginalName();
                    $fullFileName = pathinfo($fullFileName,PATHINFO_FILENAME);
                    $excelSheetFileName = $fullFileName . $filingId . '-' . $date . '.xlsx';
                    $excelSheetPath = $excel->storeAs($storagePath, $excelSheetFileName);
                    $excelHtmlConv = new ExcelHtmlConverter(
                        storage_path('app/') . $excelSheetPath, $sheetNames,
                        $filingId, $financialStatementsPath);

                    $table = $excelHtmlConv->convert();
                    foreach ($table as $key => $value) {
                        FilingFinancialData::insert([
                            'filing_id' => $filingId,
                            'fs_file_path' => $value
                        ]);
                    }
                    $fsIncluded = true;
                }
            }

            $filingExhibitPath = StorageHelper::getFilingExhibitsPath($companyId, $filingId);
            if (isset($request['exhibits']) && !empty($request['exhibits'])){
                foreach ($request['exhibits'] as $word){
                    if (isset($word['file']) && !is_null($word['file'])){
                        $exhibitFile = $word['file'];
                        $exhibitName = $word['exhibit_name'];
                        $exhibitFilePath = $filingExhibitPath . '/' . $exhibitName . '.html';
                        file_put_contents($exhibitFilePath , $exhibitFile);
                        $this->storeFilingExhibitData($filingId, $word, $exhibitFilePath);
                        $exhibitsIncluded = true;
                    }
                }
            }

            $wordDocumentPath = StorageHelper::getWordDocumentPathPath($companyId, $filingId);
            $htmlDocumentPath = StorageHelper::getHtmlDocumentPath($clientId, $filingId);
//            if(isset($request['word_document'])){
//                $word = $request['word_document'];
//                $wordFileName = $word->getClientOriginalName() . $filingId . '-' . $date . '.doc';
//                $wordPath = $word->storeAs($wordDocumentPath, $wordFileName);
//                $wordHtml = new WordHtml($filingId,
//                    storage_path('app/') . $wordPath,
//                    $htmlDocumentPath,
//                    $word->getClientOriginalName()
//                );
//                $wordHtml->convert();
//                $wordDocumentIncluded = true;
//            }
        }
        catch (\Exception $exception) {
            Filing::where('id', $filingId)->delete();
            \Log::error($exception->getMessage());
            return \Redirect::route('generate-filing.index', ['client_id' => $clientId])->withError('Error while uploading data, please try again');
        }

        return ['filingId' => $filingId, 'exhibits' => $exhibitsIncluded, 'fs' => $fsIncluded];
    }

    public function storeFilingExhibitData($filingId, $data, $filePath){
        $filingExhibit = new FilingExhibits();
        $exhibit = Exhibits::where('code', $data['code'])->first();

        $filingExhibitData['filing_id'] = $filingId;
        $filingExhibitData['exhibit_id'] = $exhibit->id;
        $filingExhibitData['exhibit_name'] = $data['exhibit_name'];
        $filingExhibitData['exhibit_description'] = $data['exhibit_description'];
        $filingExhibitData['exhibit_file_path'] = $filePath;
        $filingExhibit->store($filingExhibitData);

        return $filingExhibit;
    }

    public function storeContent()
    {
        abort_if(Gate::denies('filing_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request = \Request::all();
        $form_type = $request['form_type'];
        $plan_id = Client::where('id', Client::getCurrentClientId())->first()->plan_id;
        $form = PlanForm::join('forms', 'forms.id', '=', 'form_id')->where('plan_id', $plan_id)->where('is_active', 1)->where('forms.type', $form_type)->first();
        if ($form == null) {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
        $filing = $this->storeFiling($request);
        $filingId = $filing['filingId'];

        if (!empty($filing['fs'])) {
            return \Redirect::route('generate-filing.confirm-data', $filingId);
        } else if ($filing['exhibits']) {
            return \Redirect::route('generate-filing.confirm-exhibits', $filingId);
        } else {
            $this->saveFilingAsDraft($filingId);
            return \Redirect::route('editor.edit-content', $filingId);
        }
    }

    public function saveFilingAsDraft($filingId){
        $editor = new Editor($filingId);
        $content = $editor->getFilingContent();
        $draft = new Drafts($filingId, $content);
        $draft->storeAsDraft();
        Filing::where('id', $filingId)->update(['status' => 'in progress']);
    }

    public function confirmFinancialStatements($filingId){
        $filing = Filing::where('id', $filingId)->first();
        if (!$filing){
            abort(404);
        }

        $filingData = new GetFilingData($filingId);
        $fsFiles = $filingData->getFilingFSPaths();

        if (empty($fsFiles) || count($fsFiles) === 0){
            return \Redirect::route('editor.edit-content', $filingId);
        }

        $fsContent = $this->getFSContent($fsFiles);

        if (empty($fsContent)){
            return \Redirect::route('editor.edit-content', $filingId);
        }
        return view('Form::confirmationForm')->with(['filingId' => $filingId, 'fsContent' => $fsContent]);
    }

    public function updateFinancialData(){
        $request = \Request::all();
        $filingId = $request['filingId'];
        if(isset($request['fs']) && !empty($request['fs']) && !is_null($request['fs'])){
            $fs = $request['fs'];
            $this->setFilingFS($filingId, $fs);
        }
        return \Redirect::route('generate-filing.confirm-exhibits', $filingId);
    }

    public function updateExhibits(){
        $request = \Request::all();
        $filingId = $request['filingId'];
        if(isset($request['exhibits']) && !empty($request['exhibits']) && !is_null($request['exhibits'])){
            $exhibits = $request['exhibits'];
            $this->setFilingExhibits($filingId, $exhibits);
        }

//        return \Redirect::route('generate-filing.confirm-converted-document', $filingId);
        $this->saveFilingAsDraft($filingId);
        return \Redirect::route('editor.edit-content', $filingId);

    }

    public function confirmExhibits($filingId){
        $filingData = new GetFilingData($filingId);
        $exhibitFiles = $filingData->getFilingExhibitPaths();
        if (empty($exhibitFiles) || count($exhibitFiles) === 0){
            return \Redirect::route('generate-filing.confirm-converted-document', $filingId);
        }
        $exhibitsContent = $this->getExhibitContent($exhibitFiles);

        if (empty($exhibitsContent)){
            return \Redirect::route('editor.edit-content', $filingId);
        }

        return view('Form::confirmExhibits')->with(['filingId' => $filingId, 'exhibitContent' => $exhibitsContent]);
    }

    public function confirmConvertedDocument($filingId){

        $clientId = Client::getCurrentClientId();

        $htmlDocumentPath = StorageHelper::getHtmlDocumentPath($clientId, $filingId);
        $path = $htmlDocumentPath. '/test.blade.php';
        if(!file_exists($path)){
            $this->saveFilingAsDraft($filingId);
            return \Redirect::route('editor.edit-content', $filingId);
        }

        $filingData = new GetFilingData($filingId);
        $fsData = [];
        $filingFS = $filingData->getFilingFSData();
        if (!empty($filingFS)) {
            foreach ($filingFS as $item) {
                $fsContent = file_get_contents($item->fs_file_path);
                $fsData[$item->fs_type] = $fsContent;
            }
        }

        $exhibits = [];
        $filingExhibits = $filingData->getFilingExhibitsData();
        foreach ($filingExhibits as $item){
            $exhibits[$item->exhibit_name] = $item->exhibit_description;
        }

        $content = view()->file($path)->with(['fsData' => $fsData, 'exhibits' => $exhibits, 'filingId' => $filingId]);
        return view('Form::confirmConvertedDocument')->with(['filingId' => $filingId, 'content' => $content, 'fsData' => $fsData]);
    }

    public function updateConvertedDocument(){
        $request = \Request::all();
        $filingId = $request['filingId'];
        $clientId = Client::getCurrentClientId();
        $htmlDocumentPath = StorageHelper::getHtmlDocumentPath($clientId, $filingId);
        $path = $htmlDocumentPath. '/test.blade.php';
        if($request['word_document'] == 'skipped'){
            File::delete($path);
        }

        $this->saveFilingAsDraft($filingId);
        return \Redirect::route('editor.edit-content', $filingId);
    }

    function getExhibitContent($exhibitFiles){
        foreach ($exhibitFiles as $file){
            $pathInfo = pathinfo($file);
            $fileName = $pathInfo['filename'];
            $exhibitsContent[$fileName] = file_get_contents($file);
        }
        return $exhibitsContent;
    }

    function getFSContent($fsFiles){
        $fsContent = [];
        foreach ($fsFiles as $file) {
            $pathInfo = pathinfo($file);
            $fileName = $pathInfo['filename'];
            $fsContent[$fileName] = file_get_contents($file);
        }
        return $fsContent;
    }

    function setFilingExhibits($filingId, $exhibits){
        $filingData = new GetFilingData($filingId);
        $unConfirmedFilingExhibits = $filingData->getFilingExhibitPaths();
        foreach ($exhibits as $code => $status){
            if ($status == 'skipped'){
                $filePath = $this->findExhibitPathByCode($code, $unConfirmedFilingExhibits);
                FilingExhibits::where('filing_id', $filingId)->where('exhibit_file_path', $filePath)->delete();
                if (!is_null($filePath) && file_exists($filePath)){
                    unlink($filePath);
                }
            }
        }
    }

    function setFilingFS($filingId, $fs){
        $filingData = new GetFilingData($filingId);
        $unConfirmedFilingFS = $filingData->getFilingFSPaths();
        $availableTypes = [
            'balance_sheet',
            'statements_of_operations',
            'statements_of_stockholders_deficit',
            'statements_of_cashflows',
            'other'
        ];

        foreach ($fs as $sheetName => $data){
            $status = $data['status'];
            $type = $data['type'];
            $filePath = $this->findExhibitPathByCode($sheetName, $unConfirmedFilingFS);

            if ($status == 'confirmed' && in_array($type, $availableTypes)){
                FilingFinancialData::where('filing_id', $filingId)->where('fs_file_path', $filePath)->update(['fs_type' => $type]);
            } else {
                FilingFinancialData::where('filing_id', $filingId)->where('fs_file_path', $filePath)->delete();
                if (!is_null($filePath) && file_exists($filePath)){
                    unlink($filePath);
                }
            }
        }
    }

    function findExhibitPathByCode($code, $exhibitPaths){
        foreach ($exhibitPaths as $exhibitPath) {
            if (Str::contains($exhibitPath, $code)){
                return $exhibitPath;
            }
        }
        return null;
    }


    /*
     * Method will generate XBRL for first page right now.
     * Also will zip files including html content
     * returns zip file path
     */

    public function generateFiling(){
        $request = \Request::all();
        $formType = $request['formType'];
        if($formType == "10Q"){
            return $this->generateFilingTenQ($request);
        } else if($formType == 'Form3' || $formType == 'Form4' || $formType == 'Form5' || $formType == 'FormD' || $formType == '13FHR' ) {
            return $this->generateFilingFORM($request);
        } else {
            return $this->generateFilingWithoutXBRL($request);
        }
    }

    function generateFilingFORM($request){
        $formType = $request['formType'];
        $filingId = $request['filingId'];

        $data = $request['data'];
        $htmlContent = $request['htmlContent'];
        $dataArray = (\GuzzleHttp\json_decode($data, true));

        $zipName = $formType;


        if($formType == 'Form3'){
            $xmlGenerator = new FormThreeGenerator($dataArray, $filingId);
        } else if($formType == 'Form4'){
            $xmlGenerator = new FormFourGenerator($dataArray, $filingId);
        } else if($formType == 'Form5'){
            $xmlGenerator = new FormFiveGenerator($dataArray, $filingId);
        } else if($formType == 'FormD'){
            $xmlGenerator = new FormDGenerator($dataArray, $filingId);
        } else if($formType == '13FHR'){
            $xmlGenerator = new Form13FHRGenerator($dataArray, $filingId);
        }
        $files = $xmlGenerator->generateXml();


        if ($formType == '13FHR'){
            $files['table.xml'] = $xmlGenerator->generateTable();
            $tableContent = $request['tableContent'];
            file_put_contents('table.html', $tableContent);
            $files['table.html'] = public_path() . '/table.html';
        }
        file_put_contents($formType.'.html', $htmlContent);
        $files[$formType.'.html'] = public_path() . '/'. $formType . '.html';


        $zipGenerator = new GenerateZip($zipName, $files);
        //This method will zip files and delete them
        $zipGenerator->generateZip();
        $zipFileName = $zipGenerator->zipFileName;


        return \Response::json(array(
            'success' => true,
            'file_name' => $formType.'.zip',
            'url_to_file'   => '/generate-filing/download-zip/'.$zipFileName
        ));
    }

    public function generateFilingTenQ($request){
        $filingId = $request['filingId'];
        $htmlContent = $request['htmlContent'];
        $filingData = new GetFilingData($filingId);

        $company = $filingData->getCompany();
        $endDate = $filingData->getEndDate();
        $endDate = str_replace('-', '', $endDate);

        $tags = new Tags($filingId);
        $filingTags = $tags->getFilingTags();

        $xmlGenerator = new XBRLGenerator($filingId, $filingTags);
        $files = $xmlGenerator->generate();


        $zipName = '_10Q_';
        $filingContent = StorageHelper::getFilingDraftFilePath($company->id, $filingId);
        $content = file_get_contents($filingContent);
        file_put_contents('10Q.html', $htmlContent);

        $exhibitsFiles = (new GenerateExhibits($filingId))->generateExhibits();
        $files[$company->symbol.'-'.$endDate.'.html'] = public_path() . '/10Q.html';

        if($exhibitsFiles){
          $files = array_merge($files, $exhibitsFiles);
        }

        $zipGenerator = new GenerateZip($zipName, $files);
        //This method will zip files and delete them
        $zipGenerator->generateZip();
        $zipFileName = $zipGenerator->zipFileName;

        return \Response::json(array(
            'success' => true,
            'file_name' => '10Q.zip',
            'url_to_file'   => '/generate-filing/download-zip/'.$zipFileName
        ));
    }

    public function generateFilingWithoutXBRL($request){
      $formType = $request['formType'];
      $filingId = $request['filingId'];
      $htmlContent = $request['htmlContent'];
//      $filingData = new GetFilingData($filingId);
//      $company = $filingData->getCompany();
//      $htmlContent = StorageHelper::getFilingDraftFilePath($company->id, $filingId);
//      $content = file_get_contents($htmlContent);

      $zipName = $formType;

      file_put_contents($formType.'.html', $htmlContent);
      $exhibitsFiles = (new GenerateExhibits($filingId))->generateExhibits();
      $files[$formType.'.html'] = public_path() . '/'. $formType . '.html';

      $files = array_merge($files, $exhibitsFiles);

      $zipGenerator = new GenerateZip($zipName, $files);
      //This method will zip files and delete them
      $zipGenerator->generateZip();
      $zipFileName = $zipGenerator->zipFileName;

      return \Response::json(array(
          'success' => true,
          'file_name' => $formType.'.zip',
          'url_to_file'   => '/generate-filing/download-zip/'.$zipFileName
      ));
    }

    public function downloadZip($fileName){
        $headers = ["Content-Type" => "application/zip"];
        $filepath = storage_path('app/public') . '/' . $fileName;
        return response()->download($filepath, $fileName, $headers);
    }

    public function massDestroy(MassDestroyGenerateFilingDataRequest $request)
    {
        Filing::whereIn('id',request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    /*function prepareTags($tags){
        foreach ($tags as $key => $tag){
            if (!(isset($tag['start-date']) || isset($tag['instant']))) {
                unset($tags[$key]);
            }
        }
        return $tags;
    }*/

//    function prepareNotes($notes){
//        foreach ($notes as $key => &$tag){
//            if (isset($tag['tags'])){
//                foreach ($tag['tags'] as $key1 => $item){
//                    if (!(isset($item['start-date']) || isset($item['instant']))) {
//                        unset($tag['tags'][$key1]);
//                    }
//                }
//
//            }
//        }
//        return $notes;
//    }

    public function addNewExhibitContent(){
        $request = \Request::all();
        $countExhibits = $request['exhibitNumber'];
        $exhibits = Exhibits::all();

        $view = (string)view('Form::add-exhibit-partial')->with(['id' => (int)$countExhibits + 1, 'exhibits' => $exhibits]);
        return \Response::json(array(
            'success'=> true,
            'exhibit' => $view
        ), 200);

    }
}
