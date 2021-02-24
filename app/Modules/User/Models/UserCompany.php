<?php

namespace App\Modules\User\Models;


use App\Models\Multitenancy\MultitenancyModel;

class UserCompany extends MultitenancyModel
{
    public $table = 'user_company';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'company_id',
    ];

    public function store($userId, $companyId){
        $data['user_id'] = $userId;
        $data['company_id'] = $companyId;
        return UserCompany::create($data);
    }
}
