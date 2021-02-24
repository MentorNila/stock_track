<?php

namespace App\Modules\Filing\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Company\Models\Company;
use App\Modules\Filing\Logic\Filings;
use App\Modules\Filing\Models\Filing;
use App\Modules\Filing\Models\ReviewerFiling;
use App\Modules\Filing\Requests\MassDestroyFilingDataRequest;
use App\Modules\Filing\Requests\StoreFilingDataRequest;
use App\Modules\Filing\Requests\UpdateFilingDataRequest;
use App\Modules\User\Models\UserCompany;
use Gate;
use Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class FilingDataController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('filing_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $filings = (new Filings())->getFilings();

        return view('Filing::filings')->with('filings', $filings);
    }

    public function showFilingData($filingId){
        abort_if(Gate::denies('filing_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $filingDatas = Filing::where('id', $filingId)->get();

        return view('Filing::index', compact('filingDatas'));
    }

    public function create()
    {
        abort_if(Gate::denies('filing_data_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('Filing::create');
    }

    public function store(StoreFilingDataRequest $request)
    {
        $filingData = Filing::create($request->all());

        return redirect()->route('filing-datas.index');
    }

    public function edit(Filing $filingData)
    {
        abort_if(Gate::denies('filing_data_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('Filing::edit', compact('filingData'));
    }

    public function update(UpdateFilingDataRequest $request, Filing $filingData)
    {
        $filingData->update($request->all());

        return redirect()->route('filing-datas.index');
    }

    public function show(Filing $filingData)
    {
        abort_if(Gate::denies('filing_data_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.filingDatas.show', compact('filingData'));
    }

    public function destroy(Filing $filingData)
    {
        abort_if(Gate::denies('filing_data_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $filingData->delete();

        return back();
    }

    public function massDestroy(MassDestroyFilingDataRequest $request)
    {
        Filing::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
