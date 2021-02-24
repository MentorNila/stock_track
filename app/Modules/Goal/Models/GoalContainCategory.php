<?php

namespace App\Modules\Goal\Models;

use App\Modules\Company\Models\Company;
use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class GoalContainCategory extends MultitenancyModel
{
    public $table = 'goal_contain_categories';

    protected $fillable = [
        'goal_id',
        'category_id',
    ];

    public function getGoalCategories() {
        if($employeeId) {
            $goals = DB::table(Goal::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.employee_id')
            ->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')
            ->where('u.employee_id', '=', $employeeId);
        } else {
            $goals = DB::table(Goal::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.employee_id')
            ->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id');
        }
        return $goals;
    }
}
