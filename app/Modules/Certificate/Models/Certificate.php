<?php

namespace App\Modules\Certificate\Models;

use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class Certificate extends MultitenancyModel
{
    public $table = 'certificates';

    protected $fillable = [
        'company_id',
        'shareholder_id',
        'stock_class',
        'total_shares',
        'issued_date',
        'reservation',
        'address',
        'nr_of_paper',
        'restriction',
        'received_from',
        'acquired',
        'amt_share',
        'fmw',
        'broker',
        'cost_of_basis_received',
    ];

}
