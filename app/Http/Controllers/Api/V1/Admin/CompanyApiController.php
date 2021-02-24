<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Modules\Company\Models\Company;
use App\Http\Controllers\Controller;
use App\Modules\Company\Requests\StoreCompanyRequest;
use App\Modules\Company\Requests\UpdateCompanyRequest;
use App\Modules\Company\Resources\CompanyResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('client_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CompanyResource(Company::with(['user'])->get());
    }

    public function store(StoreCompanyRequest $request)
    {
        $client = Company::create($request->all());
        $client->user()->sync($request->input('user', []));

        return (new CompanyResource($client))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Company $client)
    {
        abort_if(Gate::denies('client_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CompanyResource($client->load(['user']));
    }

    public function update(UpdateCompanyRequest $request, Company $client)
    {
        $client->update($request->all());
        $client->user()->sync($request->input('user', []));

        return (new CompanyResource($client))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Company $client)
    {
        abort_if(Gate::denies('client_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $client->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
