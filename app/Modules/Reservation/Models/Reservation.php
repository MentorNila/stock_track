<?php

namespace App\Modules\Reservation\Models;

use App\Models\Multitenancy\MultitenancyModel;
use App\Modules\Certificate\Models\Certificate;
use App\Modules\Shareholder\Models\Shareholder;

class Reservation extends MultitenancyModel
{
    public $table = 'reservations';

    protected $fillable = [
        'company_id',
        'shareholder_id',
        'code',
        'class',
        'description',
        'reserved',
        'shares_issued',
        'start_date',
        'end_date',
    ];

    public function shareholder()
    {
        return $this->belongsTo(Shareholder::class);
    }
}