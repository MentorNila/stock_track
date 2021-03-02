<?php

namespace App\Modules\Certificate\Controllers;

use App\Modules\Company\Logic\CompanyLogic;
use App\Http\Controllers\Controller;
use App\Modules\Role\Logic\Roles;
use App\Modules\Company\Models\Company;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Goal\Models\Goal;
use App\Modules\Shareholder\Models\Shareholder;
use App\Modules\Certificate\Models\Certificate;
use Gate;
use Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CertificatesController extends Controller
{
    public function index(Request $request)
    {
        $shareholders = Shareholder::get();
        $certificates = Certificate::get();
        return view('Certificate::index', compact('shareholders', 'certificates'))->with(['shareholders' => $shareholders, 'certificates' => $certificates]);
    }

    public function store(Request $request) {
        $certificateData = $request->all();
        $activeCompany = $request->session()->get('activeCompany');
        $certificateData['company_id'] = $activeCompany->id;
        $certificateData = Certificate::create($certificateData);
        return redirect()->route('admin.certificates.index');
    }

    
    public function edit($certificateId)
    {
        $user_id = Auth::user()->id;
        $shareholders = Shareholder::get();
        $certificate = Certificate::find($certificateId);

        return view('Certificate::edit', compact('certificate', 'shareholders'));
    }

    public function update(Request $request, $certificateId)
    {
        $certificate = Certificate::find($certificateId);
        $certificate->update($request->all());
        
        return redirect()->route('admin.certificates.index');
    }

    public function delete($certificateId) {
        Certificate::destroy($certificateId);
        return redirect()->route('admin.certificates.index');
    }
}
