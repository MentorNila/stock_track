<?php

namespace App\Modules\Role\Requests;

use App\Modules\Role\Models\Role;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreRoleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'title'         => [
                'required',
            ],
            'code'         => [
                'required',
            ],
            'level'         => [
                'required',
            ],
        ];
    }
}
