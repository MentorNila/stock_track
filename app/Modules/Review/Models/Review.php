<?php

namespace App\Modules\Review\Models;

use App\Modules\Company\Models\Company;
use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Template\Models\Template;
use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class Review extends MultitenancyModel
{
    public $table = 'reviews';

    protected $fillable = [
        'employee_id',
        'created_by',
        'template_id',
        'author_id',
        'start_date',
        'status'
    ];

    public function getMyTeamReviews($employeeId = null) {
        $reviews = DB::table(Review::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.employee_id')
            ->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')
            ->join(Employee::getTableName() . ' as from_employee', 'from_employee.id', '=', 'u.author_id')
            ->join(User::getTableName() . ' as from', 'from.id', '=', 'from_employee.user_id')
            ->leftJoin(Template::getTableName() . ' as g', 'g.id', '=', 'u.template_id')
            ->where('from_employee.id', '=', $employeeId);
        return $reviews;
    }

    public function getReviewsOfMe($employeeId = null) {
        $reviews = DB::table(Review::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.employee_id')
            ->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')
            ->join(Employee::getTableName() . ' as from_employee', 'from_employee.id', '=', 'u.author_id')
            ->join(User::getTableName() . ' as from', 'from.id', '=', 'from_employee.user_id')
            ->leftJoin(Template::getTableName() . ' as g', 'g.id', '=', 'u.template_id')
            ->where('u.employee_id', '=', $employeeId);
        return $reviews;
    }

    public function getReviews() {
        $reviews = DB::table(Review::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.employee_id')
            ->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')
            ->join(Employee::getTableName() . ' as from_employee', 'from_employee.id', '=', 'u.author_id')
            ->join(User::getTableName() . ' as from', 'from.id', '=', 'from_employee.user_id')
            ->leftJoin(Template::getTableName() . ' as g', 'g.id', '=', 'u.template_id');
        return $reviews;
    }
}
