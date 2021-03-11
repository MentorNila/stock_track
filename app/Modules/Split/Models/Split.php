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
        'ordinary_dividend',
        'cash_dividend',
        'capital_gains',
        'non_dividend_distribution',
        'rate',
        'status'
    ];

}