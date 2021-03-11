<?php

namespace App\Modules\Company\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Client\Facade\ClientFacade;
use App\Modules\Client\Models\Client;
use App\Modules\Company\Logic\CompanyLogic;
use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyHistory;
use App\Modules\Company\Models\CompanyNote;
use App\Modules\Company\Requests\MassDestroyCompanyRequest;
use App\Modules\Company\Requests\StoreCompanyRequest;
use App\Modules\Company\Requests\UpdateCompanyRequest;
use App\Modules\User\Models\UserCompany;
use Gate;
use Auth;
use DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class CompanyController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $activeEmployee = $request->session()->get('activeEmployee');
        $companies = (new CompanyLogic)->getCompanies();

        return view('Company::index', compact('companies', 'activeEmployee'));
    }

    public function create(){
        abort_if(Gate::denies('company_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('Company::create');
    }

    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create($request->all());
        $notes = $request->notes;
        foreach($notes as $currentNote) {
            CompanyNote::create(['company_id' => $company->id, 'note' => $currentNote]);
        }

        (new UserCompany())->store(auth()->user()->id,$company->id);

        return redirect()->route('admin.companies.index');
    }

    public function set($companyId, Request $request) {
        $activeCompany = Company::find($companyId);
        $request->session()->put('activeCompany', $activeCompany);
        return redirect()->route('admin.companies.index');
    }

    public function edit(Company $company)
    {
        abort_if(Gate::denies('company_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company->load('users');

        $user_id = Auth::user()->id;
        $companyHistory = CompanyHistory::where('company_id', $company->id)->get();
        $companyNotes = CompanyNote::where('company_id', $company->id)->get();

        return view('Company::edit', compact('company', 'companyHistory', 'companyNotes'));
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $companyDetails = Company::find($company->id);
        if($companyDetails->name != $request->name) {
            CompanyHistory::create(['company_id' => $company->id, 'old_name' => $companyDetails->name, 'name' => $request->name]);
        }
        $company->update($request->all());
        
        return redirect()->route('admin.companies.index');
    }

    public function unactive($companyId)
    {
        $company = Company::find($companyId);
        $company->active = 0;
        $company->save();
        return redirect()->route('admin.companies.index');
    }
    
    public function active($companyId)
    {
        $company = Company::find($companyId);
        $company->active = 1;
        $company->save();
        return redirect()->route('admin.companies.index');
    }

    public function show(Company $company)
    {
        abort_if(Gate::denies('company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company->load('users');
        $user_id = Auth::user()->id;

        if(!Auth::user()->is_superadmin){
            abort_if($companyfiling == null, Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        return view('Company::show', compact(['company']));
    }

    public function destroy(Company $company)
    {
        abort_if(Gate::denies('company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company->delete();

        return back();
    }

    public function massDestroy(\Request $request)
    {
        Company::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
