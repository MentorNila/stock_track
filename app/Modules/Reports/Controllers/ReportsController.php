<?php

namespace App\Modules\Reports\Controllers;

use App\Modules\AuditLogs\Models\AuditLog;
use App\Modules\Company\Logic\CompanyLogic;
use App\Http\Controllers\Controller;
use App\Modules\Role\Logic\Roles;
use App\Modules\Company\Models\Company;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Goal\Models\Goal;
use App\Modules\Review\Models\ReviewForm;
use Gate;
use Illuminate\Support\Facades\Auth;
use Route;
use App\Modules\Filing\Models\Filing;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportsController extends Controller
{
    public function __construct(Request $request) {

    }

    public function index(Request $request, $type = null)
    {
        $activeEmployee = $request->session()->get('activeEmployee');
        if($type == 'forms') {
            $forms = (new ReviewForm())->getAllForms();
            return view('Reports::forms', compact('activeEmployee', 'forms'))->with(['activeEmployee', 'forms']);
        }
        return view('Reports::index', compact('activeEmployee'))->with(['activeEmployee']);
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
        $activeEmployee = $request->session()->get('activeEmployee');
        $employees = (new Employee())->getEmployees();
        $employees = $employees->select('e.id', 'u.first_name', 'u.last_name')->get();
        return view('Goal::create', compact('employees', 'activeEmployee'))->with(['employees' => $employees, 'activeEmployee' => $activeEmployee]);
    }

    public function store(Request $request) {
        $requestData = $request->all();
        unset($requestData['_token']);
        if(is_array($requestData['employees'])) {
            foreach($requestData['employees'] as $key => $currentEmployee) {
                $requestData['employee_id'] = $currentEmployee;
                $goal = Goal::create($requestData);
                $goal->save();
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
}
