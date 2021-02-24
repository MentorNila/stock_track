<?php

namespace App\Modules\Templates\Models;

use App\Modules\Company\Models\Company;
use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Template\Models\Template;
use App\Modules\Form\Models\Form;
use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class TemplateMember extends MultitenancyModel
{
    public $table = 'template_members';

    protected $fillable = [
        'template_id',
        'employee_id',
        'type',
    ];

}
