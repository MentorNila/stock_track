<?php

namespace App\Modules\Dashboard\Controllers;

use App\Modules\Review\Models\ReviewForm;
use App\Modules\Goal\Models\FormGoal;
use App\Modules\Goal\Models\Goal;
use Gate;
use Illuminate\Support\Facades\Auth;
use Route;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class HomeController
{
    public function index(Request $request)
    {
        $activeEmployee = $request->session()->get('activeEmployee');
        $formsINeedToDo = (new ReviewForm())->getFormsINeedToDo($activeEmployee->employee_id);
        $goals = DB::table(FormGoal::getTableName() . ' as u')
            ->join(Goal::getTableName() . ' as goal', 'u.goal_id', '=', 'goal.id')
            ->where('u.employee_id', '=', $activeEmployee->id)
            ->groupBy('u.status')
            ->select('u.status', DB::raw('COUNT(u.status) as total'))
            ->get();
        $statuses = [];
        $statusCounts = [];
        foreach($goals as $key => $currentGoal) {
        	$statuses[] = $currentGoal->status;
        	$statusCounts[] = $currentGoal->total;
        }
        return view('Dashboard::home', compact('activeEmployee', 'formsINeedToDo'))->with(['activeEmployee' => $activeEmployee, 'formsINeedToDo' => $formsINeedToDo, 'statuses' => $statuses, 'statusCounts' => $statusCounts]);
    }
}
