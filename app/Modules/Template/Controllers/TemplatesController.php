<?php

namespace App\Modules\Template\Controllers;

use App\Modules\Company\Logic\CompanyLogic;
use App\Http\Controllers\Controller;
use App\Modules\Role\Logic\Roles;
use App\Modules\Company\Models\Company;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Feedback\Models\Feedback;
use App\Modules\Form\Models\Question;
use App\Modules\Form\Models\Form;
use App\Modules\Template\Models\TemplateForm;
use App\Modules\Template\Models\Template;
use Gate;
use Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TemplatesController extends Controller
{
    public function index(Request $request)
    {
        $activeEmployee = $request->session()->get('activeEmployee');
        $forms = (new Form())->getForms();
        $forms = $forms->select('u.id', 'u.title', 'u.updated_at')->get();
        $employees = (new Employee())->getEmployees();
        $employees = $employees->select('e.id', 'u.first_name', 'u.last_name')->get();
        $templates = (new Template())->getTemplates();
        $templates = $templates->select('u.id', 'u.title', 'u.updated_at')->get();
        return view('Template::index', compact('forms', 'employees', 'templates', 'activeEmployee'))->with(['forms' => $forms, 'employees' => $employees, 'templates' => $templates, 'activeEmployee' => $activeEmployee]);
    }

    public function delete($templateId) {
        Template::destroy($templateId);
        return redirect()->route('admin.templates.index');
    }

    public function store(Request $request) {
        $requestData = $request->all();
        unset($requestData['_token']);
        $formData['title'] = $requestData['title'];
        $template = Template::create($formData);
        if($template->save()) {
            foreach($requestData['form'] as $key => $currentTemplateForm) {
                $currentTemplateFormData['form_id'] = $currentTemplateForm;
                $currentTemplateFormData['author'] = $requestData['author'][$key];
                $currentTemplateFormData['signer'] = $requestData['signer'][$key];
                $currentTemplateFormData['days_to_author'] = $requestData['days_to_author'][$key];
                $currentTemplateFormData['days_to_finish_signing'] = $requestData['days_to_finish_signing'][$key];
                $currentTemplateFormData['template_id'] = $template->id;
                $templateForm = TemplateForm::create($currentTemplateFormData);
                $templateForm->save();
                $currentTemplateFormData = [];
            }
        }
        
        return redirect()->route('admin.templates.index');
    }
}
