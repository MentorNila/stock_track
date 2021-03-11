<?php

namespace App\Modules\Company\Models;

use App\Models\Multitenancy\MultitenancyModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyNote extends MultitenancyModel
{
    use SoftDeletes;
    public $table = 'company_notes';

    protected $fillable = [
        'company_id',
        'note'
    ];

}
