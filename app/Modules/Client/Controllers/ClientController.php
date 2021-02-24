<?php

namespace App\Modules\Client\Controllers;

use App\Modules\Client\Facade\ClientFacade;
use App\Modules\Plans\Models\Plan;
use App\Modules\Register\Models\ClientRequest;
use App\Http\Controllers\Controller;
use App\Models\Multitenancy\MultitenancyHelper;
use App\Modules\Client\Models\Client;
use App\Modules\Package\Models\Package;
use App\Modules\Client\Models\ClientAdmin;
use App\Modules\Client\Requests\MassDestroyClientRequest;
use App\Modules\Client\Requests\StoreClientRequest;
use App\Modules\Client\Requests\UpdateClientRequest;
use App\Modules\Role\Classes\RoleCode;
use App\Modules\User\Models\User;
use App\Modules\User\Models\UserStatusCode;
use Gate;
use Auth;
use DB;
use Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request as NewRequest;
use TenantDatabase;


class ClientController extends Controller
{
    public function __construct() {
        $this->isPost = Request::isMethod('post');
    }

    public function index(NewRequest $request)
    {
        $activeEmployee = $request->session()->get('activeEmployee');
        abort_if(Gate::denies('client_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');


            if (Auth::user()->is_superadmin) {
                $clients = Client::all();
            }
            $clients = Client::all();


            return view('Client::index', compact('clients', 'activeEmployee'));

    }

    public function create()
    {
        abort(404);
    }

    public function checkIfSubdomainExists(){
        $request = \Request::all();
        $subdomain = $request['subdomain'];
        if(isset($request['id'])){
            $subdomain = Client::where('subdomain', $subdomain)->where('id','!=', $request['id'])->first();
            if($subdomain){
                return \Response::json(array(
                    'success'=> 'true'
                ), 200);
                } else {
                    return \Response::json(array(
                        'success' => 'false',
                    ), 200);
                }
            }
        $client = Client::where('subdomain', $subdomain)->first();
        if($client){
            return \Response::json(array(
                'success'=> 'true'
            ), 200);
        } else {
            return \Response::json(array(
                'success' => 'false',
            ), 200);
        }
    }

    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->all());

        return redirect()->route('admin.clients.index');
    }

    public function edit(Client $client)
    {
        abort_if(Gate::denies('client_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plans = Plan::all();
        $packages = Package::all();

        return view('Client::edit',compact('client', 'plans', 'packages'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {

        $inputs = $request->all();

        $clientData = [
            'name' => $inputs['name'],
            'active_date' => $inputs['active_date'],
            'plan_id' => $inputs['plan_id'],
            'subdomain' => $inputs['subdomain'],
            'status' => $inputs['status'],
            'expired_date' => $inputs['expired_date'],
        ];

        if (is_null($inputs['subdomain'])) {
            $clientData['subdomain'] = '';
        }

        if (isset($inputs['never_expire'])) {
            $clientData['expired_date'] = null;
        }

        $client->update($clientData);
        return redirect()->route('admin.clients.index');
    }



    public function show(Client $client)
    {
        abort_if(Gate::denies('client_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('Client::show', compact(['client']));
    }

    public function destroy(Client $client)
    {
        abort_if(Gate::denies('client_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $client->delete();

        return back();
    }

    public function massDestroy(MassDestroyClientRequest $request)
    {
        Client::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function register($id = 0, NewRequest $request)
    {

        $activeEmployee = $request->session()->get('activeEmployee');
        abort_if(Gate::denies('client_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plans = Plan::all();
        $packages = Package::all();
        if ($id === 0) {
            return view('Client::register')->with(['plans' => $plans, 'packages' => $packages, 'activeEmployee' => $activeEmployee]);
        }


        $requestData = ClientRequest::find($id);

        return view('Client::register')->with(['data' => $requestData, 'packages' => $packages, 'activeEmployee' => $activeEmployee]);
    }

    public function postRegister()
    {
        $inputData = Request::all();

        try {
            $siteData = [
                'subdomain' => $inputData['subdomain'],
                'name' => $inputData['name'],
                'admin_id' => $inputData['admin_id'],
                'plan_id' => $inputData['plan_id'],
                'status' => $inputData['status'],
                'active_date' => $inputData['active_date']
            ];
            $client = Client::create($siteData);
            $clientId = $client->id;
            $this->createSubSite($clientId);



            if (isset($inputData['request_id'])){

                $requestedData = ClientRequest::where('id', $inputData['request_id'])->first();
                MultitenancyHelper::run(function() use ($requestedData) {
                    $userData = [
                        'name'           => $requestedData->first_name,
                        'email'          => $requestedData->email,
                        'is_superadmin'  => 1,
                        'password'       => '$2y$10$bbWk2eIxRUx6fFlAosl12O.EtSe47pf6jh85KTWDiURRh5aLzGHIm',
                        'remember_token' => null,
                        'role_id'        => 1,
                        'created_at'     => '2019-08-19 11:47:42',
                        'updated_at'     => '2019-08-19 11:47:42',
                        'deleted_at'     => null,
                    ];
                    User::create($userData);
                }, $clientId);

                (new ClientRequest())->updateRequestStatus($inputData['request_id']);

            }

            return redirect()->route('admin.clients.index');

        } catch ( \ValidationException $e ) {
            return redirect()->route('clients.register')->withInput()->withErrors( $e->get_errors() );
        }
    }





    // public function register(){
    //
    //     if (!empty($_SERVER['HTTP_REFERER']) && ($this->isPost) && !empty(Request::input('is_fill'))) {
    //
    //         $referer = parse_url($_SERVER['HTTP_REFERER']);
    //         $referer = $referer['host'];
    //         $referer_root = config('modules.client.domain_client_form');
    //         if($referer == $referer_root){
    //             return $this->postRegister();
    //         }
    //         else{
    //             return redirect()->route('home');
    //         }
    //     }
    //     else{
    //         if($this->isPost){
    //             return $this->postRegister();
    //         } else{
    //             return view('Client::register');
    //         }
    //     }
    // }

    /*public function postRegister(){

        $inputData = Request::all();
        try {
//            $data_validator = $this->_validator->validate($inputData);
            $clientAdmin = [
                'username' 	=> $inputData['username'],
                'email' 	=> $inputData['email'],
                'password' => $inputData['password'],
                'password_confirmation' => $inputData['password_confirmation'],
                'gender' => $inputData['gender'],
                'first_name' => $inputData['first_name'],
                'last_name' => $inputData['last_name'],
                'company' => $inputData['company'],
                'title' => $inputData['title'],
                'telephone' => $inputData['telephone'],
                'country_id' => $inputData['country_id'],
                'language_code' => $inputData['language_code'],
                'contact_name' => $inputData['contact_name'],
                'contact_email' => $inputData['contact_email'],
                'customer_number' => $inputData['customer_number'],
                'is_read_policy' => isset($inputData['is_read_policy']) ? $inputData['is_read_policy'] : ''
            ];

            $token = uniqid('', true);
            $clientAdmin['password'] = bcrypt($clientAdmin['password']);
            foreach ($clientAdmin as $key => $value) {
                if (empty($value)) {
                    unset($clientAdmin[$key]);
                }
            }
            $clientAdmin = ClientAdmin::create($clientAdmin);
            $defaultPlan = config('modules.client.plan_default');
            $defaultPlan = $defaultPlan[$inputData['site_type']];
            $siteData = [
                'is_domain' => $inputData['domain_radio'],
                'subdomain' => $inputData['subdomain'],
                'mode' => $inputData['site_type'],
                'name' => $inputData['company_name'],
                'active_key' => $token,
                'admin_id' => $clientAdmin->id,
                'plan_id'	=> $defaultPlan
            ];
            $client = Client::create($siteData);

            $this->sendEmailConfirm($client, $clientAdmin);
            Session::flash('message', trans('client::register.please_check_email_confirm'));
            return view('user::notification');

        } catch ( \ValidationException $e ) {
            return redirect()->route('client.register')->withInput()->withErrors( $e->get_errors() );
        }
    }*/

    public function confirm(){
        $token = Request::get('token');
        $id = Request::get('id');
        $clientModel = new Client;
        $client = $clientModel->checkToken($id, $token);
        if($client){
            $clientModel->updateActive($client->id);
            $this->createSubSite($client->id);
            $this->moveClientAdminToUser($client->id, $client->admin_id);

            $fullurl = sub_site($client->subdomain, $client->is_domain);
            return view('client::site_created')->with('fullurl', $fullurl);
        }else{
            Session::flash('not_ok_message', trans('client::register.token_not_found'));
            return view('user::notification');
        }
    }

    public function createSubSite($id){
        TenantDatabase::createTables($id);
        return true;
    }

    public function moveClientAdminToUser($clientId, $admin_id){
        $clientAdmin = ClientAdmin::where('id', '=', $admin_id)->first();
        MultitenancyHelper::run(function($client) use($clientAdmin) {
            $userData = [
                'username' 	=> $clientAdmin->username,
                'email' 	=> $clientAdmin->email,
                'password' => $clientAdmin->password,
                'gender' => $clientAdmin->gender,
                'first_name' => $clientAdmin->first_name,
                'last_name' => $clientAdmin->last_name,
                'company' => $clientAdmin->company,
                'title' => $clientAdmin->title,
                'telephone' => $clientAdmin->telephone,
                'country_id' => $clientAdmin->country_id,
                'language_code' => $clientAdmin->language_code,
                'contact_name' => $clientAdmin->contact_name,
                'contact_email' => $clientAdmin->contact_email,
                'customer_number' => $clientAdmin->customer_number,
                'is_read_policy' => $clientAdmin->is_read_policy,
                'role_id' => \ViewVars::getRoleId(RoleCode::$SUPER_ADMIN),
                'status' => UserStatusCode::$ACTIVATED,
            ];
            User::create($userData);
        }, $clientId);
    }

}
