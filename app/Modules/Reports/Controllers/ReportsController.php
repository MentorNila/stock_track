<?php

namespace App\Modules\Reports\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Shareholder\Models\Shareholder;
use App\Modules\Certificate\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ReportsController extends Controller
{
    public function __construct(Request $request)
    {
    }

    public function index(Request $request, $reportKey = null)
    {
        $shareholders = Shareholder::get();
        $activeCompany = $request->session()->get('activeCompany');
        if (isset($activeCompany->id)) {
            $shareholders = Shareholder::where('company_id', $activeCompany->id)->get();
        }
        $reportNames = [
            'active_shares' => 'Total Active Shares by Stock Class/Shareholder'
        ];
        if ($reportKey) {
            $totalCompanyShares = Certificate::where('company_id', $activeCompany->id)->sum('total_shares');
            $shareHolderData = [];
            foreach ($shareholders as $currentShareholder) {
                $activeShares = Certificate::where('shareholder_id', $currentShareholder->id)->sum('total_shares');
                $shareHolderData[$currentShareholder->id] = $activeShares;
            }
            return view('Reports::specific', [
                'reportName' => $reportNames[$reportKey],
                'reportKey' => $reportKey,
                'shareholders' => $shareholders,
                'totalCompanyShares' => $totalCompanyShares,
                'shareholderData' => $shareHolderData
            ]);
        }
        return view('Reports::index');
    }
}
