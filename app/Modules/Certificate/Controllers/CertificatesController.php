<?php

namespace App\Modules\Certificate\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Shareholder\Models\Shareholder;
use App\Modules\Certificate\Models\Certificate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CertificatesController extends Controller
{
    public function index(Request $request)
    {
        $shareholders = Shareholder::get();
        $certificates = Certificate::get();
        $activeCompany = $request->session()->get('activeCompany');
        if(isset($activeCompany->id)) {
            $shareholders = Shareholder::where('company_id', $activeCompany->id)->get();
            $certificates = Certificate::where('company_id', $activeCompany->id)->get();
        }
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
