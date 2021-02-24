<?php

namespace App\Modules\Client\Requests;

use App\Modules\Company\Models\Client;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreClientRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('client_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'subdomain' => 'required|unique:clients',
            'name' => 'required',
            'active_date' => 'required|date',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'subdomain.required' => 'A subdomain is required',
            'subdomain.unique' => 'Subdomain should be unique',
            'name.required'  => 'A name is required',
            'active_date.required'  => 'An active date is required',
            'active_date.date'  => 'Active date should be a date',
            'status.required'  => 'A status is required',
        ];
    }
}
