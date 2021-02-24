<?php

namespace App\Modules\Company\Requests;

use App\Modules\Company\Models\Company;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreCompanyRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('client_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
