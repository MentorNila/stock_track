<?php

namespace App\Modules\Review\Controllers;

use App\Modules\Company\Logic\CompanyLogic;
use App\Http\Controllers\Controller;
use App\Modules\Role\Logic\Roles;
use App\Modules\Company\Models\Company;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Template\Models\TemplateForm;
use App\Modules\Template\Models\Template;
use App\Modules\Review\Models\Review;
use App\Modules\Review\Models\ReviewForm;
use App\Modules\Form\Models\Form;
use App\Modules\Goal\Models\Goal;
use App\Modules\Goal\Models\FormGoal;
use Gate;
use Route;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReviewsController extends Controller
{
    public function index(Request $request)
    {
        $activeEmployee = $request->session()->get('activeEmployee');
        $loggedInUserId = Auth::user()->id;
        $currentEmployee = Employee::where(['user_id' => $loggedInUserId])->first();
        $currentEmployeeId = $currentEmployee->id;
        $employees = (new Employee())->getEmployees();
        $employees = $employees->select('e.id', 'u.first_name', 'u.last_name')->get();
        $templates = (new Template())->getTemplates();
        $templates = $templates->select('u.id', 'u.title', 'u.updated_at')->get();
        $reviews = (new Review())->getMyTeamReviews();
        $reviews = $reviews->select('u.id', 'e.first_name', 'e.last_name', 'g.title', 'u.start_date', 'u.status')->get();
        $reviewsOfMe = (new Review())->getReviewsOfMe($activeEmployee->employee_id);
        $reviewsOfMe = $reviewsOfMe->select('u.id', 'e.first_name', 'e.last_name', 'g.title', 'u.start_date', 'u.status')->get();
        $reviewForms = (new ReviewForm())->getReviewForms();
        $formsINeedToDo = (new ReviewForm())->getFormsINeedToDo($activeEmployee->employee_id); 
        $formsIDid = (new ReviewForm())->getFormsIDid($activeEmployee->employee_id);
        return view('Review::index', compact('templates', 'employees', 'reviews', 'reviewForms', 'formsINeedToDo', 'activeEmployee'))->with(['reviewForms' => $reviewForms, 'employees' => $employees, 'templates' => $templates, 'reviews' => $reviews, 'formsINeedToDo' => $formsINeedToDo, 'formsIDid' => $formsIDid, 'reviewsOfMe' => $reviewsOfMe, 'activeEmployee' => $activeEmployee]);
    }

    public function company(Request $request)
    {
        $activeEmployee = $request->session()->get('activeEmployee');
        $loggedInUserId = Auth::user()->id;
        $currentEmployee = Employee::where(['user_id' => $loggedInUserId])->first();
        $currentEmployeeId = $currentEmployee->id;
        $employees = (new Employee())->getEmployees();
        $employees = $employees->select('e.id', 'u.first_name', 'u.last_name')->get();
        $templates = (new Template())->getTemplates();
        $templates = $templates->select('u.id', 'u.title', 'u.updated_at')->get();
        $reviews = (new Review())->getReviews();
        $reviews = $reviews->select('u.id', 'e.first_name', 'e.last_name', 'g.title', 'u.start_date', 'u.status')->get();
        return view('Review::company', compact('templates', 'employees', 'reviews', 'activeEmployee'))->with(['employees' => $employees, 'templates' => $templates, 'reviews' => $reviews, 'activeEmployee' => $activeEmployee]);
    }

    public function view($reviewId, Request $request) {
        $activeEmployee = $request->session()->get('activeEmployee');
        $review = DB::table(Review::getTableName() . ' as u')->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.employee_id')->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')->where('u.id', '=', $reviewId)->leftJoin(Template::getTableName() . ' as g', 'g.id', '=', 'u.template_id')->select('u.id', 'e.first_name', 'e.last_name', 'u.template_id', 'u.start_date', 'g.title')->first();
        $templateForms = TemplateForm::where('template_id' , '=', $review->template_id)->get();

        $reviewForms = (new ReviewForm())->getReviewForms($review->id);
        return view('Review::show', compact('review', 'templateForms', 'reviewForms', 'activeEmployee'))->with(['review' => $review, 'templateForms' => $templateForms, 'reviewForms' => $reviewForms, 'activeEmployee' => $activeEmployee]);
    }

    public function delete($reviewId) {
        $review = Review::destroy($reviewId);
        return redirect()->route('admin.reviews.index');
    }

    public function delete_form($formId) {
        ReviewForm::destroy($formId);
        return redirect()->route('admin.reviews.index');
    }

    public function store(Request $request) {
        $loggedInUserId = Auth::user()->id;
        $currentEmployee = Employee::where(['user_id' => $loggedInUserId])->first();
        $currentEmployeeId = $currentEmployee->id;
        $requestData = $request->all();
        unset($requestData['_token']);
        $reviewData = $requestData;
        $reviewData['author_id'] = $currentEmployeeId;
        $requestData['employee_id'] = $requestData['employee_id'];
        $requestData['created_by'] = $currentEmployeeId;
        $reviewData['status'] = 1;
        $review = Review::create($reviewData);
        $review->save();
        
        if($reviewData['template_id'] != 'none') {
            $template = Template::find($reviewData['template_id']);
            $templateForms = TemplateForm::where('template_id' , '=', $template->id)->get();
            foreach($templateForms as $key => $currentForm) {
                $due_date_authors = new DateTime($requestData['start_date']);
                $due_date_authors->modify('+' . (int)$currentForm['days_to_author'] . ' days');
                $due_date_authors = $due_date_authors->format('Y-m-d');
                $due_date_signers = new DateTime($due_date_authors);
                $due_date_signers = $due_date_signers->modify('+' . (int)$currentForm['days_to_finish_signing'] . ' days');
                $due_date_signers = $due_date_signers->format('Y-m-d');
                $reviewFormData = [];
                $reviewFormData['review_id'] = $review->id;
                $reviewFormData['form_id'] = $currentForm['form_id'];
                $reviewFormData['author'] = $currentForm['author'];
                $reviewFormData['signer'] = $requestData['employee_id'];
                $reviewFormData['due_date_authors'] = $due_date_authors;
                $reviewFormData['due_date_signers'] = $due_date_signers;
                $reviewFormData['status'] = 2;
                $reviewForm = ReviewForm::create($reviewFormData);
                $reviewForm->save();
            }
            return redirect()->route('admin.reviews.view', $review->id);
        }
        return redirect()->route('admin.reviews.index');
    }

    public function form($formId = null, Request $request) {
        $activeEmployee = $request->session()->get('activeEmployee');
        $form = DB::table(ReviewForm::getTableName() . ' as u')
        ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.signer')
        ->join(Review::getTableName() . ' as t', 't.id', '=', 'u.review_id')
        ->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')
        ->join(Employee::getTableName() . ' as p', 'p.id', '=', 'u.author')
        ->join(User::getTableName() . ' as l', 'l.id', '=', 'p.user_id')
        ->join(Form::getTableName() . ' as form', 'form.id', '=', 'u.form_id')
        ->leftJoin(Template::getTableName() . ' as k', 'k.id', '=', 't.template_id')->select('u.id', 'e.first_name as signer_first_name', 'e.last_name as signer_last_name', 'e.id as employee_id', 'l.first_name as author_first_name', 'l.last_name as author_last_name', 't.start_date', 'k.title', 'u.due_date_authors', 'u.due_date_signers', 'form.title as form_title', 'form.id as form_id', 't.id as review_id')->where('u.id', '=', $formId)->first();
        $reviewId = $form->review_id;
        $review = DB::table(Review::getTableName() . ' as u')->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.employee_id')->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')->where('u.id', '=', $reviewId)->leftJoin(Template::getTableName() . ' as g', 'g.id', '=', 'u.template_id')->select('u.id', 'e.first_name', 'e.last_name', 'u.template_id', 'u.start_date', 'g.title')->first();
        $formQuestions = Form::find($form->form_id)->questions;
        $employeeGoals = DB::table(Goal::getTableName() . ' as u')
        ->join(Employee::getTableName() . ' as p', 'p.id', '=', 'u.employee_id')
        ->join(User::getTableName() . ' as e', 'e.id', '=', 'p.user_id')
        ->where('p.id', '=', $form->employee_id)
        ->leftJoin(FormGoal::getTableName() . ' as formGoal', 'u.id', '=', 'formGoal.goal_id')
        ->select('u.*', 'e.first_name as first_name', 'e.last_name as last_name', 'formGoal.value as progress')
        ->get();
        $formGoals = (new FormGoal())->getFormGoals($formId);
        return view('Review::form', compact('form', 'formQuestions','employeeGoals', 'review', 'activeEmployee', 'formGoals'))->with(['form' => $form, 'formQuestions' => $formQuestions, 'employeeGoals' => $employeeGoals, 'review' => $review, 'activeEmployee' => $activeEmployee, 'formGoals' => $formGoals]);
    }

    public function submit_form($formId = null, Request $request) {
        $requestData = $request->all();
        $form = DB::table(ReviewForm::getTableName() . ' as u')
        ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.signer')
        ->join(Review::getTableName() . ' as t', 't.id', '=', 'u.review_id')
        ->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')
        ->join(Employee::getTableName() . ' as p', 'p.id', '=', 'u.author')
        ->join(User::getTableName() . ' as l', 'l.id', '=', 'p.user_id')
        ->join(Form::getTableName() . ' as form', 'form.id', '=', 'u.form_id')
        ->leftJoin(Template::getTableName() . ' as k', 'k.id', '=', 't.template_id')->select('u.id', 'e.first_name as signer_first_name', 'e.last_name as signer_last_name', 'e.id as employee_id', 'l.first_name as author_first_name', 'l.last_name as author_last_name', 't.start_date', 'k.title', 'u.due_date_authors', 'u.due_date_signers', 'form.title as form_title', 'form.id as form_id', 't.id as review_id')->where('u.id', '=', $formId)->first();
        $reviewId = $form->review_id;
        $employeeId = $form->employee_id;
        if(isset($requestData['goalId'])) {
            foreach($requestData['goalId'] as $key => $goal) {
                $goalData['review_id'] = $reviewId;
                $goalData['employee_id'] = $employeeId;
                $goalData['form_id'] = $formId;
                $goalData['goal_id'] = $requestData['goalId'][$key];
                $goalData['discussion'] = $requestData['discussion'][$key];
                $goalData['goal_score'] = $requestData['goal_score'][$key];
                $goalData['status'] = 'SUBMITTED';
                $formGoal = FormGoal::create($goalData);
                $formGoal->save();
            }
        }
        if(isset($requestData['formGoalId'])) {
            foreach($requestData['formGoalId'] as $key => $id) {
                $formGoal = FormGoal::find($id);
                $formGoal->discussion = $requestData['formGoalDiscussion'][$key];
                $formGoal->goal_score = $requestData['formGoalScore'][$key];
                $formGoal->save();
            }
        }
        return redirect()->back()->with('success', 'Submitted');   
    }
}
