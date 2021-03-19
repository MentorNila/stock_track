<?php

namespace App\Modules\Reservation\Models;

use App\Models\Multitenancy\MultitenancyModel;
use App\Modules\Certificate\Models\Certificate;

class Reservation extends MultitenancyModel
{
    public $table = 'reservations';

    protected $fillable = [
        'company_id',
        'code',
        'class',
        'description',
        'reserved',
        'shares_issued',
        'start_date',
        'end_date',
    ];

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}