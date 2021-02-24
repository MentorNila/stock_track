<?php

namespace App\Modules\Transaction\Models;

use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class Transaction extends MultitenancyModel
{
    public $table = 'transactions';

    protected $fillable = [
        'company_id',
        'sec_tracking',
        'item_count',
        'scl',
        'control_ticket',
        'received',
        'inw_received',
        'track',
        'content',
        'assigned_to'
    ];

}
