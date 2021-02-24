<?php

namespace App\Modules\Template\Models;

use App\Modules\Company\Models\Company;
use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class TemplateForm extends MultitenancyModel
{
    public $table = 'template_forms';

    protected $fillable = [
        'form_id',
        'template_id',
        'author',
        'signer',
        'days_to_author',
        'days_to_finish_signing',
    ];

    public function getTemplates() {
        $templates = DB::table(Feedback::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.employee_id')->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')->join(Employee::getTableName() . ' as from_employee', 'r.id', '=', 'u.created_by')->join(User::getTableName() . ' as from', 'from.id', '=', 'from_employee.user_id')->join(Goal::getTableName() . ' as g', 'g.id', '=', 'u.goal_id');
            return $templates;
    }
}
