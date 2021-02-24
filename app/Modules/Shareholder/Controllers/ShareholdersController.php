<?php

namespace App\Modules\Shareholder\Controllers;

use App\Modules\Company\Logic\CompanyLogic;
use App\Http\Controllers\Controller;
use App\Modules\Role\Logic\Roles;
use App\Modules\Company\Models\Company;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Goal\Models\Goal;
use App\Modules\Shareholder\Models\Shareholder;
use Gate;
use Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShareholdersController extends Controller
{
    public function index(Request $request)
    {
        $shareholders = Shareholder::get();
        return view('Shareholder::index', compact('shareholders'))->with(['shareholders' => $shareholders]);
    }

    public function store(Request $request) {
        $shareholderData = $request->all();
        $activeCompany = $request->session()->get('activeCompany');
        $shareholderData['company_id'] = $activeCompany->id;
        Shareholder::create($shareholderData);
        return redirect()->route('admin.shareholders.index');
    }

    public function unactive($shareholderId)
    {
        $shareholder = Shareholder::find($shareholderId);
        $shareholder->active = 0;
        $shareholder->save();
        return redirect()->route('admin.shareholders.index');
    }

    public function edit($shareholderId)
    {
        $shareholder = Shareholder::find($shareholderId);
        return view('Shareholder::edit', compact('shareholder'));
    }
    
    public function update(Request $request, $shareholderId)
    {
        $shareholder = Shareholder::find($shareholderId);
        $shareholder->update($request->all());
        
        return redirect()->route('admin.shareholders.index');
    }
}
