<?php

namespace App\Modules\Employee\Models;

use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class Employee extends MultitenancyModel
{
    public $table = 'employees';

    protected $fillable = [
        'job_title',
        'phone_nr',
        'user_id',
        'supervisor_id',
        'hire_date',
        'termination_date',
    ];

    public function getEmployees(){
        $employees = DB::table(User::getTableName() . ' as u')
            ->join(Role::getTableName() . ' as r', 'r.id', '=', 'u.role_id')
            ->join(Employee::getTableName() . ' as e', 'u.id', '=', 'e.user_id')
            ->leftJoin(Employee::getTableName() . ' as employee_supervisor', 'employee_supervisor.id', '=', 'e.supervisor_id')
            ->leftJoin(User::getTableName() . ' as supervisor', 'supervisor.id', '=', 'employee_supervisor.user_id');
        return $employees;
    }
}
