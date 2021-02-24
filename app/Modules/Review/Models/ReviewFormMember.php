<?php

namespace App\Modules\Review\Models;

use App\Modules\Company\Models\Company;
use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Template\Models\Template;
use App\Modules\Form\Models\Form;
use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class ReviewFormMember extends MultitenancyModel
{
    public $table = 'review_form_members';

    protected $fillable = [
        'review_form_id',
        'employee_id',
        'type',
        'signed',
    ];

}
