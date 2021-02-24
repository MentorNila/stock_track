<?php

namespace App\Modules\Form\Models;

use App\Modules\Company\Models\Company;
use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Form\Models\Question;
use App\Modules\Goal\Models\Goal;
use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class Form extends MultitenancyModel
{
    public $table = 'forms';

    protected $fillable = [
        'title'
    ];

    public function getForms() {
        $forms = DB::table(Form::getTableName() . ' as u');
        return $forms;
    }

    public function questions()
    {
        return $this->hasMany('App\Modules\Form\Models\Question');
    }
}
