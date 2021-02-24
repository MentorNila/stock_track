<?php

namespace App\Modules\Goal\Models;

use App\Modules\Company\Models\Company;
use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class Goal extends MultitenancyModel
{
    public $table = 'goals';

    protected $fillable = [
        'name',
        'target',
        'units',
        'start_date',
        'due_date',
        'description',
        'category',
        'employee_id',
        'transparency',
        'alignment',
    ];

    public function getGoals($employeeId = null) {
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
