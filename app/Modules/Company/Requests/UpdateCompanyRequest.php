<?php

namespace App\Modules\Company\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('client_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [

        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
