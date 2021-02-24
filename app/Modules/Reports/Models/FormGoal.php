<?php

namespace App\Modules\Goal\Models;

use App\Modules\Company\Models\Company;
use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use App\Modules\Goal\Models\Goal;
use App\Modules\Employee\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class FormGoal extends MultitenancyModel
{
    public $table = 'form_goals';

    protected $fillable = [
        'form_id',
        'goal_id',
        'discussion',
        'goal_score',
        'question_id',
        'employee_id',
        'value',
    ];

    public function getFormGoals($formId = null) {
        if($formId) {
            $goals = DB::table(FormGoal::getTableName() . ' as u')
            ->join(Goal::getTableName() . ' as goal', 'u.goal_id', '=', 'goal.id')
            ->where('u.form_id', '=', $formId)
            ->select('u.*', 'goal.name', 'u.id as form_goal_id')->get();
        } else {
            $goals = DB::table(FormGoal::getTableName() . ' as u')
            ->join(Goal::getTableName() . ' as goal', 'u.goal_id', '=', 'goal.id')
            ->select('u.*', 'goal.name', 'u.id as form_goal_id')->get();
        }
        return $goals;
    }
}
