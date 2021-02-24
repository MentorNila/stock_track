<?php

namespace App\Modules\Company\Logic;

use App\Modules\Company\Models\Company;

class CompanyLogic
{
    public function __construct(){

    }

    public function getCompanies(){
        $companies = auth()->user()->companies;

        if(auth()->user()->is_superadmin){
            $companies = Company::all();
        }

        return $companies;
    }

}
