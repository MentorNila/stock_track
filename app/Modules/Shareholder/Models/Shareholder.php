<?php

namespace App\Modules\Shareholder\Models;

use App\Models\Multitenancy\MultitenancyModel;
use App\Modules\Certificate\Models\Certificate;

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

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

}
