<?php

namespace App\Modules\Employee\Controllers;

use App\Modules\AuditLogs\Models\AuditLog;
use App\Modules\Company\Logic\CompanyLogic;
use App\Http\Controllers\Controller;
use App\Modules\Role\Logic\Roles;
use App\Modules\Company\Models\Company;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use Gate;
use Illuminate\Support\Facades\Auth;
use Route;
use App\Modules\Filing\Models\Filing;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        $loggedInUser = Auth::user();
        $loggedInUserId = $loggedInUser->id;
        $currentEmployee = DB::table(User::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as e', 'u.id', '=', 'e.user_id')
            ->where('e.user_id', '=', $loggedInUserId)
            ->select('e.*', 'e.id as employee_id', 'u.*')
            ->first();
        $request->session()->put('currentEmployee', $currentEmployee);
        if($loggedInUser->role_id == 5) {
            return $this->set($currentEmployee->id, $request);
        }
        $activeEmployee = $request->session()->get('activeEmployee');
        if(is_null($activeEmployee)) {
            $this->set($currentEmployee->id, $request);
        }
        $users = (new Employee())->getEmployees();
        $users = $users->select('u.id as id', 'u.name as name', 'u.first_name', 'u.last_name', 'u.email as email', 'r.title as role_title', 'e.id as employee_id', 'e.job_title', 'e.phone_nr', 'supervisor.first_name as supervisor_first_name', 'supervisor.last_name as supervisor_last_name')
            ->distinct()->get();
        return view('Employee::index', compact('users', 'activeEmployee'))->with(['users' => $users, 'activeEmployee' => $activeEmployee]);
    }

    public function org(Request $request) {
        $supervisors = [];
        $employees = (new Employee())->getEmployees();
        $employees = $employees->select('e.id', 'u.first_name', 'u.last_name', 'e.job_title', 'e.supervisor_id')->get();
        foreach($employees as $employee) {
            $supervisors[$employee->supervisor_id][] = $employee;
        }
        $activeEmployee = $request->session()->get('activeEmployee');
        return view('Employee::org', compact('activeEmployee', 'employees', 'supervisors'))->with(['activeEmployee' => $activeEmployee, 'employees' => $employees, 'supervisors']);
    }

    public function create(Request $request)
    {
        $employees = (new Employee())->getEmployees();
        $employees = $employees->select('e.id', 'u.first_name', 'u.last_name')->get();
        $activeEmployee = $request->session()->get('activeEmployee');
        return view('Employee::create', compact('activeEmployee', 'employees'))->with(['activeEmployee' => $activeEmployee, 'employees' => $employees]);
    }

    public function set($employeeId, Request $request)
    {
        $activeEmployee = DB::table(User::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as e', 'u.id', '=', 'e.user_id')
            ->where('e.id', '=', $employeeId)
            ->select('e.*', 'e.id as employee_id', 'u.*')
            ->first();
        $request->session()->put('activeEmployee', $activeEmployee);

        $loggedInUserId = Auth::user()->id;
        $currentEmployee = DB::table(User::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as e', 'u.id', '=', 'e.user_id')
            ->where('e.user_id', '=', $loggedInUserId)
            ->select('e.*', 'e.id as employee_id', 'u.*')
            ->first();
        $request->session()->put('currentEmployee', $currentEmployee);
        return redirect()->route('admin.home');
    }

    public function store(Request $request) {
        $requestData = $request->all();
        $requestData['name'] = $requestData['first_name'];
        $user = new User;
        $user->role_id = 5;
        if(isset($requestData['superuser']) && $requestData['superuser'] == 1) {
            $user->is_superadmin = 1;
            $user->role_id = 1;
        }
        $user->name = $requestData['first_name'];
        $user->first_name = $requestData['first_name'];
        $user->last_name = $requestData['last_name'];
        $user->email = $requestData['email'];
        $user->password = $requestData['password'];
        $user->save();
        $requestData['user_id'] = $user->id;
        unset($requestData['_token']);
        $employee = Employee::create($requestData);
        $employee->save();

        return redirect()->route('admin.employees.index');
    }

    public function edit(Request $request, $userId)
    {
        $employees = (new Employee())->getEmployees();
        $employees = $employees->select('e.id', 'u.first_name', 'u.last_name')->get();
        $activeEmployee = $request->session()->get('activeEmployee');
        $user = DB::table(User::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as e', 'u.id', '=', 'e.user_id')
            ->where('e.user_id', '=', $userId)
            ->select('e.*', 'e.id as employee_id', 'u.*')
            ->first();

        $roles = (new Roles())->prepareRoleByLevel();
        $companies = (new CompanyLogic)->getCompanies();

        return view('Employee::edit', compact('roles', 'user', 'companies', 'activeEmployee', 'employees'));
    }


    public function update(Request $request, $userId)
    {
        $user = User::find($userId);
        $user->first_name = $request->all()['first_name'];
        $user->last_name = $request->all()['last_name'];
        $user->save();

        $employee = Employee::where('user_id', '=', $userId)->first();
        $employee->job_title = isset($request->all()['job_title'])? $request->all()['job_title'] : $employee->job_title;
        $employee->phone_nr = isset($request->all()['phone_nr'])? $request->all()['phone_nr'] : $employee->phone_nr;
        $employee->address = isset($request->all()['address'])? $request->all()['address'] : $employee->address;
        $employee->supervisor_id = isset($request->all()['supervisor_id'])? $request->all()['supervisor_id'] : $employee->supervisor_id;
        $employee->hire_date = isset($request->all()['hire_date'])? $request->all()['hire_date'] : $employee->hire_date;
        $employee->termination_date = isset($request->all()['termination_date'])? $request->all()['termination_date'] : $employee->termination_date;
        $employee->state = isset($request->all()['state'])? $request->all()['state'] : $employee->state;
        $employee->supervisor_id = isset($request->all()['supervisor_id'])? $request->all()['supervisor_id'] : $employee->supervisor_id;
        $employee->birthdate = isset($request->all()['birthdate'])? $request->all()['birthdate'] : $employee->birthdate;
        $employee->save();

        return redirect()->route('admin.employees.index');
    }
}
