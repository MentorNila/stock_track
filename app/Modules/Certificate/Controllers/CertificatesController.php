<?php

namespace App\Modules\Certificate\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Shareholder\Models\Shareholder;
use App\Modules\Certificate\Models\Certificate;
use App\Modules\Transact\Models\Transact;
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
        $loggedInUser = Auth::user();
        $loggedInUserId = $loggedInUser->id;
        $certificateData = $request->all();
        $activeCompany = $request->session()->get('activeCompany');
        $certificateData['company_id'] = $activeCompany->id;
        $transactData = $certificateData;
        $transactData['assigned_to'] = $loggedInUserId;
        $certificateData['received_from'] = $certificateData['received_from_certificate'];
        Certificate::create($certificateData);
        Transact::create($transactData);
        return redirect()->route('admin.certificates.index');
    }

    
    public function edit($certificateId)
    {
        $user_id = Auth::user()->id;
        $shareholders = Shareholder::get();
        $certificate = Certificate::find($certificateId);

        return view('Certificate::edit', compact('certificate', 'shareholders'));
    }

    public function show($certificateId, Request $request) {
        $certificate = Certificate::find($certificateId);
        $activeCompany = $request->session()->get('activeCompany');
        $activeCompanyName = $activeCompany->name;
        return view('Certificate::show', compact('certificate', 'activeCompanyName'));
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
