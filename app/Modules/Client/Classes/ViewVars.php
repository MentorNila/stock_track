<?php
namespace App\Modules\Client\Classes;

use App\Modules\Role\Models\Role;
use App\Modules\User\Models\UserStatusCode;

class ViewVars {

    public function getUserStatusCode($code) {
        return UserStatusCode::$$code;
    }

    public function getRoleId($code) {
        $role = Role::where('code', '=', $code)->first();
        return $role->id;
    }

    public function getClientStatusCode($code) {
        return ClientStatusCode::$$code;
    }

    public function returnClientCode($index){
        return ClientStatusCode::returnCode($index);
    }
}

