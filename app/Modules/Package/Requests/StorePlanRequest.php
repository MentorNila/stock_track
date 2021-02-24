<?php


namespace App\Modules\Plans\Requests;


class StorePlanRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'unique:plans'
        ];
    }
}
