<?php


namespace App\Modules\Editor\Logic;


use App\Modules\Company\Models\Company;
use App\Modules\Filing\Logic\GetFilingData;
use App\Modules\Filing\Logic\StorageHelper;
use App\Modules\Filing\Models\Filing;
use App\Modules\User\Models\UserCompany;
use App\Modules\User\Models\UserFiling;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class FilingLogic
{
    private $filing;
    private $filingId;
    private $status = 'idle';
    private $user;
    public function __construct($filingId)
    {
        $this->user = Auth::user();
        $this->filingId = $filingId;
        $this->checkIfFilingExists();

    }

    function checkIfFilingExists(){
        $this->filing = Filing::find($this->filingId);

        if (!$this->filing){
            abort(404);
        }
    }

    function loadContent($request){
        $type = 'filing';
        if (isset($request['file']) && $request['file'] !== '') {
            $type = 'exhibit';
        } else if ($this->filing->status == 'in progress'){
            $type = 'draft';
        }

        $filingProperties = $this->getFilingProperties();

        $filingData = $filingProperties['filingData'];
        $formType = $filingData->getFilingType();
        $filingMode = true;
        $exhibitMode = false;
        switch ($type) {
            case 'exhibit':
                $exhibitData = $filingData->getFilingExhibitByName($request['file']);
                if (!$exhibitData || !file_exists($exhibitData->exhibit_file_path)) {
                    abort(404);
                }
                $content = file_get_contents($exhibitData->exhibit_file_path);
                $filingMode = false;
                $exhibitMode = true;
                break;
            case 'draft':
                $draftFiling = StorageHelper::getFilingDraftFilePath($filingProperties['companyId'], $this->filingId);
                if (!file_exists($draftFiling)) {
                    abort(404);
                }
                $content = file_get_contents($draftFiling);
                break;
            case 'filing':
                $editor = new Editor($this->filingId);
                $content = $editor->getFilingContent();
                break;
            default:
                return abort(404);
        }
        return ['content' => $content, 'formType' => $formType, 'filing' => $filingMode, 'exhibitMode' => $exhibitMode, 'filingProperties' => $filingProperties];
    }

    function loadExhibits(){
        $editor = new Editor($this->filingId);
        return $editor->getExhibits();

    }

    function getFilingProperties(){
        $filingData = new GetFilingData($this->filingId);
        $period = $filingData->getFilingPeriod();
        $companyId = $filingData->getCompanyId();

        $clientfiling = UserCompany::where('user_id', $this->user->id)->where('company_id', $companyId)->first();
        $userFiling = UserFiling::where('filing_id',$this->filingId)->where('user_id', $this->user->id)->first();

        if(!$this->user->is_superadmin){
            abort_if($clientfiling == null && $userFiling == null, Response::HTTP_FORBIDDEN, '403 Forbidden');
        }


        $filingUser = Company::where('id',$companyId)->first()->user_id;
        $status = $filingData->getStatus();

        return
            [
                'companyId' => $companyId,
                'period' => $period,
                'filingUser' => $filingUser,
                'status' => $status,
                'filingData' => $filingData,
                'filingId' => $this->filingId
            ];
    }
}
