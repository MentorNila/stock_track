<?php namespace App\Modules\Filing\Logic;

use App\Modules\Company\Models\Company;
use App\Modules\Filing\Models\Filing;
use App\Modules\User\Models\UserCompany;
use App\Modules\User\Models\UserFiling;
use Illuminate\Support\Facades\DB;

class Filings
{
    protected $user;

    public function __construct(){
        $this->user = auth()->user();
    }

    public function getFilings()
    {
        $filings = DB::table(Filing::getTableName() . ' as f');

        if (!$this->user->is_superadmin) {
            $filings = $this->filterByCompany($filings);
            $filings = $this->filterByAssignment($filings);
        }

        $filings = $this->prepareFilingDetails($filings);
        return $filings->get();
    }

    function filterByCompany($filings){
        $filings = $filings->leftJoin(UserCompany::getTableName() . ' as uc', function ($join) {
            $join->on('uc.company_id', '=', 'f.company_id');
        })->where('uc.user_id', $this->user->id);

        return $filings;
    }

    function filterByAssignment($filings){
        $filings = $filings->leftJoin(UserFiling::getTableName() . ' as uf', function ($join) {
            $join->on('f.id', '=', 'uf.filing_id');
        })->orWhere('uf.user_id', $this->user->id);

        return $filings;
    }

    function prepareFilingDetails($filings){
        $filings = $filings->join(Company::getTableName() . ' as c', function ($join) {
            $join->on('f.company_id', '=', 'c.id');
        })
            ->select('f.*', 'c.name as client_name')
            ->whereNull('f.deleted_at')
            ->orderBy('id', 'desc')
            ->distinct();

        return $filings;
    }
}
