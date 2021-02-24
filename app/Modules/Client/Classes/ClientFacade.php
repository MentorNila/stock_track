<?php
namespace App\Modules\Client\Classes;

use App\Modules\Client\Models\Client;
use App\Modules\Company\Models\Company;
use App\Modules\Plans\Models\Plan;

class ClientFacade {

    /**
     *
     * @param App\Modules\Client\Models\Client $client
     */
    public function setClient($client) {
        Client::setCurrentClient($client);
    }

    public function getClient() {
        return Client::getCurrentClient();
    }

    public function getMode() {
        $currentClient = Client::getCurrentClient();
        // tripple check
        if(!empty($currentClient) && isset($currentClient->mode) && !empty($currentClient->mode)){
            return $currentClient->mode;
        }
        \Log::warning("ClientFacade.php getMode() has failed. Request URL: " . \Illuminate\Support\Facades\Request::url() . ". Terminating session (404).");
        abort(404);
    }

    public function isRootDomain($subdomain = null, $backend = false) {
        if (is_null($subdomain)) {
            if($backend){
                $subdomain = "";
            }
            else {
                $subdomain = $this->getClient()->subdomain;
            }
        }
        return "" == $subdomain;
    }

    public function canCreateCompany(){

        $currentClient = Client::getCurrentClient();
        $limitedCompaniesNumber = Plan::find($currentClient->plan_id)->company_number;
        $clientCompanyNumber = Company::withTrashed()->get()->count();

        if ($clientCompanyNumber >= $limitedCompaniesNumber){
            return false;
        }
        return true;
    }

}
