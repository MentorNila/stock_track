<?php

namespace App\Modules\Client\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use Redirect;
use Request;
use Session;

class BeClientController extends Controller {
    public function __construct() {
        $this->isPost = Request::isMethod('post');
    }

    public function listClient(){
        if(\ClientFacade::isRootDomain()){
            $clientModel = new Client();
            $listClient = $clientModel->listAllClient();
            $plans = Plan::select('id', 'title', 'mode')->get()->groupBy('mode')->toJson();
            return view('client::list')->with('clients', $listClient)->with('plans', $plans);
        } else{
            return Redirect::to('/');
        }
    }

    public function update(){
        $inputData = Request::only('is_domain','domain_name', 'company_name', 'mode', 'active_date', 'expired_date', 'status', 'never_expired','plan');
        $id = Request::input('id');

        $clientData = [
            'name' => $inputData['company_name'],
            'mode' => $inputData['mode'],
            'active_date' => \Helper::convertTime($inputData['active_date']),
            'plan_id' => $inputData['plan']
        ];

        $currentClient = Client::find($id);
        //if(\ClientFacade::isRootDomain($currentClient->subdomain)){
        $clientData += [
            'is_domain' => $inputData['is_domain'],
            'subdomain' => $inputData['domain_name'],
            'status' => $inputData['status'],
            'expired_date' => \Helper::convertTime($inputData['expired_date']),
        ];
        //}

        if($inputData['never_expired']){
            $clientData['expired_date'] = null;
        }

        $clientModel = new Client();
        if($clientModel->updateClient($id, $clientData)){
            $status['code'] = 1;
            $status['message'] = 'Update successfully!';
            return $status;
        } else{
            $status['code'] = 0;
            $status['message'] = 'save error!';
            return $status;
        }
    }

    public function delete(){
        $id = \Request::input('id');
        $clientModel = new Client();
        if(!\ClientFacade::isRootDomain($clientModel->find($id)->subdomain)){
            if($clientModel->find($id)->delete()){
                $status['code'] = 1;
                $status['message'] = 'Delete successfully';
                return $status;
            }
        }
        $status['code'] = 0;
        $status['message'] = 'Delete error!';
        return $status;
    }

    public function configure() {
        if (request()->isMethod('post')) {
            $this->saveConfiguration();
        }

        return view('client::configure');
    }

    protected function saveConfiguration() {

    }
}
