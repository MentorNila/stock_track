<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Modules\Filing\Models\Filing;
use App\Http\Controllers\Controller;
use App\Modules\Filing\Requests\StoreFilingDataRequest;
use App\Modules\Filing\Requests\UpdateFilingDataRequest;
use App\Modules\Filing\Resources\FilingDataResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilingDataApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('filing_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FilingDataResource(Filing::all());
    }

    public function store(StoreFilingDataRequest $request)
    {
        $filingData = Filing::create($request->all());

        return (new FilingDataResource($filingData))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Filing $filingData)
    {
        abort_if(Gate::denies('filing_data_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FilingDataResource($filingData);
    }

    public function update(UpdateFilingDataRequest $request, Filing $filingData)
    {
        $filingData->update($request->all());

        return (new FilingDataResource($filingData))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Filing $filingData)
    {
        abort_if(Gate::denies('filing_data_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $filingData->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
