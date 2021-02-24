<?php

namespace App\Modules\Register\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Client\Facade\ClientFacade;
use App\Modules\Plans\Models\Plan;
use App\Modules\Register\Classes\ClientRequestStatusCode;
use App\Modules\Register\Models\ClientRequest;
use Gate;
use Auth;
use DB;
use Request;
use Symfony\Component\HttpFoundation\Response;


class RegisterController extends Controller
{
    public function __construct() {
        $this->isPost = Request::isMethod('post');
    }

    public function listRequests(){
        if (ClientFacade::isRootDomain()){
            return true;
        }
        abort_if(Gate::denies('request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clientRequests = ClientRequest::orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();

        return view('Register::list', compact('clientRequests'));
    }

    public function registerRequest()
    {

        $plans = Plan::where('is_public', 1)->get();
        return view('Register::create', compact('plans'));
    }

    public function postRequest(){

        $clientRequests = ClientRequest::create(Request::all());

        return redirect()->route('landingPage');
    }


    public function declineRequest($id)
    {
        $clientRequest = ClientRequest::where('id', $id)->first();
        $DECLINED = ClientRequestStatusCode::$DECLINED;
        if (ClientRequest::find($id)->update(['status' => $DECLINED])) {
            $clientRequests = ClientRequest::orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
            return view('Register::list', compact('clientRequests'));
        }

        return view('Register::showRequest', compact('clientRequest'));
    }



    public function showRequest($id){
        if (ClientFacade::isRootDomain()){
            return true;
        }
        abort_if(Gate::denies('request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clientRequest = ClientRequest::where('id', $id)->first();

        return view('Register::showRequest', compact('clientRequest'));
    }
}
