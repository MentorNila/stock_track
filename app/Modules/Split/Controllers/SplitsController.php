<?php

namespace App\Modules\Split\Controllers;

use App\Modules\Company\Logic\CompanyLogic;
use App\Http\Controllers\Controller;
use App\Modules\Role\Logic\Roles;
use App\Modules\Company\Models\Company;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Goal\Models\Goal;
use App\Modules\Shareholder\Models\Shareholder;
use Gate;
use Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SplitsController extends Controller
{
    public function index(Request $request)
    {
        $shareholders = Shareholder::get();
        return view('Split::index', compact('shareholders'))->with(['shareholders' => $shareholders]);
    }

    public function pending_transact(Request $request)
    {
        $shareholders = Shareholder::get();
        return view('Split::pending', compact('shareholders'))->with(['shareholders' => $shareholders]);
    }

    public function store(Request $request) {
        $shareholder = Shareholder::create($request->all());
        return redirect()->route('admin.shareholders.index');
    }

    public function delete($feedbackId) {
        Feedback::destroy($feedbackId);
        return redirect()->route('admin.feedbacks.index');
    }
}
