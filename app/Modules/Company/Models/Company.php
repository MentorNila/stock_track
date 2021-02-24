<?php

namespace App\Modules\Company\Models;

use App\Models\Multitenancy\MultitenancyModel;
use App\Modules\User\Models\User;
use App\Modules\User\Models\UserCompany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends MultitenancyModel
{
    use SoftDeletes;

    public $table = 'companies';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'address_one',
        'address_two',
        'address_three',
        'email',
        'federal_id',
        'last_trans_no',
        'after_proxy_date',
        'code',
        'phone_one',
        'phone_two',
        'phone_three',
        'ticker_symbol',
        'incorp_in_state',
        'proxy_record_date',
        'after_proxy_date',
        'last_holder_id',
        'date_terminated',
        'state',
        'state_short',
        'zip_code',
        'created_at',
        'updated_at',
        'deleted_at',
        'nr_of_employees',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, UserCompany::getTableName());
    }
}
