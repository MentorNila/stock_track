<?php

namespace App\Modules\Form\Controllers;

use App\Modules\Company\Logic\CompanyLogic;
use App\Http\Controllers\Controller;
use App\Modules\Role\Logic\Roles;
use App\Modules\Company\Models\Company;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Feedback\Models\Feedback;
use App\Modules\Form\Models\Question;
use App\Modules\Form\Models\Form;
use Gate;
use Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FormsController extends Controller
{
    public function index(Request $request)
    {
        $activeEmployee = $request->session()->get('activeEmployee');
        $forms = (new Form())->getForms();
        $forms = $forms->select('u.id', 'u.title', 'u.updated_at')->get();
        return view('Form::index', compact('forms', 'activeEmployee'))->with(['forms' => $forms, 'activeEmployee' => $activeEmployee]);
    }

    public function delete($formId) {
        Form::destroy($formId);
        return redirect()->route('admin.forms.index');
    }

    public function store(Request $request) {
        $loggedInUserId = Auth::user()->id;
        $currentEmployee = Employee::where(['user_id' => $loggedInUserId])->first();
        $currentEmployeeId = $currentEmployee->id;
        $requestData = $request->all();
        unset($requestData['_token']);
        $formData['title'] = $requestData['title'];
        $form = Form::create($formData);
        $form->save();
        if($form->save()) {
            foreach($requestData['type'] as $key => $currentType) {
                $currentQuestionData['type'] = $currentType;
                $currentQuestionData['question'] = $requestData['question'][$key];
                $currentQuestionData['subtext'] = $requestData['subtext'][$key];
                $currentQuestionData['form_id'] = $form->id;
                $question = Question::create($currentQuestionData);
                $question->save();
                $currentQuestionData = [];
            }
        }
        
        return redirect()->route('admin.forms.index');
    }
}
