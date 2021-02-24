<?php

namespace App\Modules\Shareholder\Models;

use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class Shareholder extends MultitenancyModel
{
    public $table = 'shareholders';

    protected $fillable = [
        'company_id',
        'ref_name',
        'name_as_appears_on_certificate',
        'registration',
        'ssno',
        'address'
    ];

}
