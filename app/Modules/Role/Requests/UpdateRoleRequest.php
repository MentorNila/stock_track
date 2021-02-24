<?php

namespace App\Modules\Role\Requests;

use App\Modules\Role\Models\Role;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateRoleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
