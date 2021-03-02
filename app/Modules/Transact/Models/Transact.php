<?php

namespace App\Modules\Transact\Models;

use App\Models\Multitenancy\MultitenancyModel;

class Transact extends MultitenancyModel
{
    public $table = 'transactions';

    protected $fillable = [
        'company_id',
        'sec_tracking',
        'item_count',
        'scl',
        'control_ticket',
        'received',
        'how_received',
        'track',
        'content',
        'status',
        'assigned_to'
    ];

}