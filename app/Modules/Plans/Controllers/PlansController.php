<?php

namespace App\Modules\Plans\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Client\Facade\ClientFacade;
use App\Modules\Form\Models\Forms;
use App\Modules\Plans\Models\Plan;
use App\Modules\Plans\Models\PlanForm;
use App\Modules\Plans\Requests\StorePlanRequest;
use App\Modules\Plans\Requests\UpdatePlanRequest;
use Gate;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;
use Request;
use Symfony\Component\HttpFoundation\Response;



class PlansController extends Controller
{
    public function index(){

        abort_if(Gate::denies('plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plans = Plan::orderBy('id', 'DESC')->get();
        return view('Plans::index', compact('plans'));

    }

    public function create(){

        abort_if(Gate::denies('plan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $forms = Forms::all()->toArray();

        return view('Plans::create')->with(['forms' => $forms]);

    }

    public function rules()
    {
        return [
            'title' => 'unique:plans,title,NULL,id,deleted_at,NULL'
        ];
    }

    public function store(){

        $request = \Request::all();
        $planData = \Request::only('title','price','company_number','description');

        $validator = Validator::make($planData, $this->rules());

        if($validator->fails()){

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $newPlan = Plan::create($planData);
        $is_public = 0;
        if(isset($request['is_public'])){
            $is_public = 1;
        }
        Plan::where('id', $newPlan->id)->update(['is_public' => $is_public]);
        if (isset($request['forms'])){
            $forms = $request['forms'];
            foreach ($forms as $formId => $form){
                $active = 0;
                if(isset($form['is_activated'])){
                    $active = 1;
                }
                $planId = $newPlan->id;
                $planData['plan_id'] = $planId;
                $planData['form_id'] = $formId;
                $planData['price_per_page'] = $form['price_per_page'];
                $planData['price_per_form'] = $form['price_per_form'];
                $planData['is_active'] = $active;

                PlanForm::create($planData);
            }
        }


        return redirect()->route('admin.plans.index');

    }


    public function show(Plan $plan)
    {

        abort_if(Gate::denies('plan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('Plans::show', compact('plan'));

    }

    public function edit(Plan $plan)
    {

        abort_if(Gate::denies('plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $forms = Forms::all()->toArray();

        $planForms = PlanForm::join('forms', 'forms.id', '=', 'form_id')->where('plan_id', $plan->id)->get()->toArray();

        return view('Plans::edit', compact('plan', 'forms', 'planForms'));

    }

    public function update(Plan $plan)
    {

        $request = \Request::all();

        $planData = \Request::only('title','price','company_number','description');

//        $validator = Validator::make($planData, $this->rules());

        $validator = Validator::make($planData, [
            'title' => 'unique:plans,title,NULL,id,deleted_at,NULL'.$plan->id
        ]);


        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $plan->update($planData);
        $is_public = 0;
        if(isset($request['is_public'])){
            $is_public = 1;
        }
        Plan::where('id', $plan->id)->update(['is_public' => $is_public]);

        return redirect()->route('admin.plans.index');
    }

    public function destroy(Plan $plan)
    {

        abort_if(Gate::denies('plan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plan->delete();

        return back();
    }

    public function massDestroy()
    {

        $request = \Request::all();
        Plan::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function updatePlanForms(Plan $plan){
        $request = \Request::all();
        if(isset($request['forms'])){
            $forms = $request['forms'];
            foreach ($forms as $formId => $form){
                $active = 0;
                if(isset($form['is_activated'])){
                    $active = 1;
                }
                $planForm = PlanForm::where('plan_id', $plan->id)->where('form_id', $formId)->first();
                if($planForm){
                    PlanForm::where('plan_id', $plan->id)->where('form_id', $formId)->update([
                        'price_per_page' => $form['price_per_page'],
                        'price_per_form' => $form['price_per_form'],
                        'is_active' => $active
                    ]);
                } else {
                    $planData['plan_id'] = $plan->id;
                    $planData['form_id'] = $formId;
                    $planData['price_per_page'] = $form['price_per_page'];
                    $planData['price_per_form'] = $form['price_per_form'];
                    $planData['is_active'] = $active;
                    PlanForm::create($planData);
                }
            }
        }

        return redirect()->route('admin.plans.index');
    }


    public function checkTitle(Request $request) {
        $request = \Request::all();
        $title = $request['title'];
        if(isset($request['id'])){
            $title = Plan::where('title', $title)->where('id','!=', $request['id'])->first();
            if($title){
                return \Response::json(array(
                    'success'=> 'true'
                ), 200);
            } else {
                return \Response::json(array(
                    'success' => 'false',
                ), 200);
            }
        }
        $plan = Plan::where('title', $title)->first();
        if($plan){
            return \Response::json(array(
                'success'=> 'true'
            ), 200);
        } else {
            return \Response::json(array(
                'success' => 'false',
            ), 200);
        }
    }


}
