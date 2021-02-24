<?php

namespace App\Modules\Filing\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreFilingDataRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('filing_data_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'code' => [
                'required',
            ],
        ];
    }
}
