<?php

namespace App\Modules\Split\Models;

use App\Models\Multitenancy\MultitenancyModel;

class Split extends MultitenancyModel
{
    public $table = 'splits';

    protected $fillable = [
        'company_id',
        'type',
        'stock_class',
        'record_date',
        'pay_date',
        'ordinary_devidend',
        'cash_devidend',
        'capital_gains',
        'non_devidend_distribution',
        'rate',
        'status'
    ];

}