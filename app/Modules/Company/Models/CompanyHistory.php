<?php

namespace App\Modules\Company\Models;

use App\Models\Multitenancy\MultitenancyModel;
use App\Modules\User\Models\User;
use App\Modules\User\Models\UserCompany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyHistory extends MultitenancyModel
{
    use SoftDeletes;

    public $table = 'company_history';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'old_name',
        'company_id'
    ];

}
