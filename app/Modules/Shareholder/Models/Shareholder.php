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
        'registration',
        'name_as_appears_on_certificate',
        'country_one',
        'address_one',
        'city_one',
        'state_one',
        'zip_one',
        'deliv_one',
        'country_two',
        'address_two',
        'city_two',
        'state_two',
        'zip_two',
        'deliv_two',
        'primary_tin_name',
        'primary_tin_radio',
        'second_tin_name',
        'second_tin_radio',
        'benefical_owner',
        'family',
        'sponsor',
        'financial_advisor',
        'employee_title',
        'officer',
        'director',
        'use_address_two_for_checks'
    ];

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
