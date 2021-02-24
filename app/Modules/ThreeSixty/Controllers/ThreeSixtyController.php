<?php

namespace App\Modules\ThreeSixty\Controllers;

use App\Modules\Company\Logic\CompanyLogic;
use App\Http\Controllers\Controller;
use App\Modules\Role\Logic\Roles;
use App\Modules\Company\Models\Company;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Goal\Models\Goal;
use App\Modules\Feedback\Models\Feedback;
use Gate;
use Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThreeSixtyController extends Controller
{
    public function index(Request $request)
    {
        $activeEmployee = $request->session()->get('activeEmployee');
        $employees = (new Employee())->getEmployees();
        $employees = $employees->select('e.id', 'u.first_name', 'u.last_name')->get();
        $feedbacks = (new Feedback())->getFeedbacks($activeEmployee->employee_id);
        $feedbacks = $feedbacks->select('u.id', 'e.first_name', 'e.last_name', 'from.first_name as from_first_name', 'from.last_name as from_last_name', 'u.feedback', 'g.name as goal_name')->get();
        return view('ThreeSixty::index', compact('feedbacks', 'employees', 'activeEmployee'))->with(['feedbacks' => $feedbacks, 'employees' => $employees, 'activeEmployee' => $activeEmployee]);
    }

    public function store(Request $request) {
        $loggedInUserId = Auth::user()->id;
        $currentEmployee = Employee::where(['user_id' => $loggedInUserId])->first();
        $currentEmployeeId = $currentEmployee->id;
        $requestData = $request->all();
        unset($requestData['_token']);
        $requestData['employee_id'] = $requestData['employee_id'];
        $requestData['created_by'] = $currentEmployeeId;
        $feedback = Feedback::create($requestData);
        $feedback->save();
        
        return redirect()->route('admin.feedbacks.index');
    }

    public function delete($feedbackId) {
        Feedback::destroy($feedbackId);
        return redirect()->route('admin.feedbacks.index');
    }
}
