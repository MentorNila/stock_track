<?php

namespace App\Modules\Form\Models;

use App\Modules\Company\Models\Company;
use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Goal\Models\Goal;
use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class Question extends MultitenancyModel
{
    public $table = 'questions';

    protected $fillable = [
        'form_id',
        'type',
        'question',
        'subtext',
        'min_value',
        'max_value',
        'value',
        'name',
        'description'
    ];

    public function getQuestions($employee_id = null) {
        $feedbacks = DB::table(Feedback::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.employee_id')->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')->join(Employee::getTableName() . ' as from_employee', 'r.id', '=', 'u.created_by')->join(User::getTableName() . ' as from', 'from.id', '=', 'from_employee.user_id')->join(Goal::getTableName() . ' as g', 'g.id', '=', 'u.goal_id');
            return $feedbacks;
    }
}
