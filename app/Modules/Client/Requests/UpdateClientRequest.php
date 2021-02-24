<?php

namespace App\Modules\Client\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateClientRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('client_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'subdomain' => 'required',
            'name' => 'required',
            'active_date' => 'required|date',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'subdomain.required' => 'A subdomain is required',
            'name.required'  => 'A name is required',
            'active_date.required'  => 'An active date is required',
            'active_date.date'  => 'Active date should be a date',
            'expire_date.date'  => 'Expire date should be a date',
            'status.required'  => 'A status is required',
        ];
    }
}
