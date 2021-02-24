<?php

namespace App\Modules\Goal\Controllers;

use App\Modules\AuditLogs\Models\AuditLog;
use App\Modules\Company\Logic\CompanyLogic;
use App\Http\Controllers\Controller;
use App\Modules\Role\Logic\Roles;
use App\Modules\Company\Models\Company;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Goal\Models\Goal;
use App\Modules\Goal\Models\GoalCategory;
use App\Modules\Goal\Models\GoalContainCategory;
use Gate;
use Illuminate\Support\Facades\Auth;
use Route;
use App\Modules\Filing\Models\Filing;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GoalsController extends Controller
{
    public function __construct(Request $request) {
    } 

    public function index(Request $request)
    {
        $activeEmployee = $request->session()->get('activeEmployee');
        $goals = (new Goal())->getGoals($activeEmployee->employee_id);
        $goals = $goals->select('u.id', 'u.employee_id', 'e.first_name', 'e.last_name', 'u.name as name', 'u.target as target', 'u.units as units', 'u.start_date as start_date', 'u.due_date as due_date')->get();
        return view('Goal::index', compact('goals', 'activeEmployee'))->with(['goals' => $goals, 'activeEmployee']);
    }

    public function company(Request $request)
    {
        $activeEmployee = $request->session()->get('activeEmployee');
        $goals = (new Goal())->getGoals();
        $goals = $goals->select('u.id', 'u.employee_id', 'e.first_name', 'e.last_name', 'u.name as name', 'u.target as target', 'u.units as units', 'u.start_date as start_date', 'u.due_date as due_date')->get();
        return view('Goal::index', compact('goals', 'activeEmployee'))->with(['goals' => $goals, 'activeEmployee']);
    }

    public function employee_goals($employeeId) {
        $goals = (new Goal())->getGoals($employeeId);
        $goals = $goals->select('u.id as id', 'u.name as name')->get();
        return response()->json([
            'goals' => $goals
        ]);
    }

    public function create(Request $request)
    {
        $categories = GoalCategory::get();
        $activeEmployee = $request->session()->get('activeEmployee');
        $employees = (new Employee())->getEmployees();
        $employees = $employees->select('e.id', 'u.first_name', 'u.last_name')->get();
        return view('Goal::create', compact('employees', 'activeEmployee', 'categories'))->with(['employees' => $employees, 'activeEmployee' => $activeEmployee, 'categories' => $categories]);
    }

    public function store(Request $request) {
        $requestData = $request->all();
        unset($requestData['_token']);
        if(is_array($requestData['employees'])) {
            foreach($requestData['employees'] as $key => $currentEmployee) {
                $requestData['employee_id'] = $currentEmployee;
                $goal = Goal::create($requestData);
                $goal->save();
                foreach($requestData['categories'] as $key => $currentCategory) {
                    $goalCategory = GoalContainCategory::create(['goal_id' => $goal->id, 'category_id' => $currentCategory]);
                    $goalCategory->save();
                }
            }
        } else {
            $requestData['employee_id'] = $requestData['employees'][0];
            $goal = Goal::create($requestData);
            $goal->save(); 
        }
        return redirect()->route('admin.goals.index');
    }

    public function delete($goalId) {
        $goal = Goal::destroy($goalId);
        return redirect()->route('admin.goals.index');
    }

    public function categories(Request $request)
    {
        $activeEmployee = $request->session()->get('activeEmployee');
        $categories = GoalCategory::get();
        return view('Goal::categories', compact('categories', 'activeEmployee'))->with(['categories' => $categories, 'activeEmployee']);
    }

    public function store_category(Request $request) {
        GoalCategory::create($request->all());
        return redirect()->route('admin.goals.categories');
    }

    public function delete_category($categoryId) {
        GoalCategory::destroy($categoryId);
        return redirect()->route('admin.goals.categories');
    }
}
