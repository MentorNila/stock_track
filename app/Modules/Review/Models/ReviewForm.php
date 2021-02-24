<?php

namespace App\Modules\Review\Models;

use App\Modules\Company\Models\Company;
use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Template\Models\Template;
use App\Modules\Form\Models\Form;
use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class ReviewForm extends MultitenancyModel
{
    public $table = 'review_forms';

    protected $fillable = [
        'form_id',
        'employee_id',
        'created_by',
        'review_id',
        'author',
        'signer',
        'start_date',
        'due_date_authors',
        'due_date_signers',
        'status'
    ];

    public function getReviewForms($reviewId = null) {
        if($reviewId) {
            $reviewForms = DB::table(ReviewForm::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.signer')
            ->join(Review::getTableName() . ' as t', 't.id', '=', 'u.review_id')
            ->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')
            ->join(Employee::getTableName() . ' as p', 'p.id', '=', 'u.author')
            ->join(User::getTableName() . ' as l', 'l.id', '=', 'p.user_id')
            ->leftJoin(Template::getTableName() . ' as k', 'k.id', '=', 't.template_id')->select('u.id', 'e.first_name as signer_first_name', 'e.last_name as signer_last_name', 'l.first_name as author_first_name', 'l.last_name as author_last_name', 't.start_date', 'k.title', 'u.due_date_authors', 'u.due_date_signers')->where('review_id', '=', $reviewId)->get();
        } else {
            $reviewForms = DB::table(ReviewForm::getTableName() . ' as u')
            ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.signer')
            ->join(Review::getTableName() . ' as t', 't.id', '=', 'u.review_id')
            ->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')
            ->join(Employee::getTableName() . ' as p', 'p.id', '=', 'u.author')
            ->join(User::getTableName() . ' as l', 'l.id', '=', 'p.user_id')
            ->leftJoin(Template::getTableName() . ' as k', 'k.id', '=', 't.template_id')->select('u.id', 'e.first_name as signer_first_name', 'e.last_name as signer_last_name', 'l.first_name as author_first_name', 'l.last_name as author_last_name', 't.start_date', 'k.title', 'u.due_date_authors', 'u.due_date_signers')->get();
        }
        return $reviewForms;
    }

    public function getFormsINeedToDo($employeeId = null) {
        $formsINeedToDo = DB::table(ReviewForm::getTableName() . ' as u')
            ->join(Form::getTableName() . ' as form', 'form.id', '=', 'u.form_id')
            ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.signer')
            ->join(Review::getTableName() . ' as t', 't.id', '=', 'u.review_id')
            ->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')
            ->join(Employee::getTableName() . ' as p', 'p.id', '=', 'u.author')
            ->join(User::getTableName() . ' as l', 'l.id', '=', 'p.user_id')
            ->leftJoin(Template::getTableName() . ' as k', 'k.id', '=', 't.template_id')
            ->select('u.id', 'e.first_name as author_first_name', 'e.last_name as author_last_name', 'l.first_name as signer_first_name', 'l.last_name as signer_last_name', 't.start_date', 'k.title', 'form.title as form_title', 'u.due_date_authors', 'u.due_date_signers', 'form.id as form_id', 'u.signer', 'u.author', 'u.status')->where('u.signer', '=', $employeeId)->get();
        return $formsINeedToDo;
    }

    public function getFormsIDid($employeeId = null) {
        $formsIDid = DB::table(ReviewForm::getTableName() . ' as u')
            ->join(Form::getTableName() . ' as form', 'form.id', '=', 'u.form_id')
            ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.signer')
            ->join(Review::getTableName() . ' as t', 't.id', '=', 'u.review_id')
            ->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')
            ->join(Employee::getTableName() . ' as p', 'p.id', '=', 'u.author')
            ->join(User::getTableName() . ' as l', 'l.id', '=', 'p.user_id')
            ->leftJoin(Template::getTableName() . ' as k', 'k.id', '=', 't.template_id')
            ->select('u.id', 'e.first_name as signer_first_name', 'e.last_name as signer_last_name', 'l.first_name as author_first_name', 'l.last_name as author_last_name', 't.start_date', 'k.title', 'form.title as form_title', 'u.due_date_authors', 'u.due_date_signers', 'form.id as form_id', 'u.signer', 'u.author', 'u.status')->where('u.author', '=', $employeeId)->get();
        return $formsIDid;
    }

    public function getAllForms() {
        $forms = DB::table(ReviewForm::getTableName() . ' as u')
            ->join(Form::getTableName() . ' as form', 'form.id', '=', 'u.form_id')
            ->join(Employee::getTableName() . ' as r', 'r.id', '=', 'u.signer')
            ->join(Review::getTableName() . ' as t', 't.id', '=', 'u.review_id')
            ->join(User::getTableName() . ' as e', 'e.id', '=', 'r.user_id')
            ->join(Employee::getTableName() . ' as p', 'p.id', '=', 'u.author')
            ->join(User::getTableName() . ' as l', 'l.id', '=', 'p.user_id')
            ->leftJoin(Template::getTableName() . ' as k', 'k.id', '=', 't.template_id')
            ->select('u.id', 'e.first_name as signer_first_name', 'e.last_name as signer_last_name', 'l.first_name as author_first_name', 'l.last_name as author_last_name', 't.start_date', 'k.title', 'form.title as form_title', 'u.due_date_authors', 'u.due_date_signers', 'form.id as form_id', 'u.signer', 'u.author', 'u.status')
            ->get();
        return $forms;
    }

}
