<?php

namespace App\Modules\Feedback\Models;

use App\Modules\Company\Models\Company;
use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Goal\Models\Goal;
use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class Feedback extends MultitenancyModel
{
    public $table = 'feedbacks';

    protected $fillable = [
        'employee_id',
        'created_by',
        'goal_id',
        'feedback'
    ];

    public function getFeedbacks($employee_id = null) {
        if($employee_id) {
            $feedbacks = DB::table(Feedback::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.employee_id')
            ->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')
            ->join(Employee::getTableName() . ' as from_employee', 'from_employee.id', '=', 'u.created_by')
            ->join(User::getTableName() . ' as from', 'from.id', '=', 'from_employee.user_id')
            ->join(Goal::getTableName() . ' as g', 'g.id', '=', 'u.goal_id')
            ->where('r.id' , '=', $employee_id);
        } else {
            $feedbacks = DB::table(Feedback::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.employee_id')
            ->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')
            ->join(Employee::getTableName() . ' as from_employee', 'from_employee.id', '=', 'u.created_by')
            ->join(User::getTableName() . ' as from', 'from.id', '=', 'from_employee.user_id')
            ->join(Goal::getTableName() . ' as g', 'g.id', '=', 'u.goal_id');
        }
        return $feedbacks;
    }
}
