<?php
namespace App\Modules\Client\Facade;

use Illuminate\Support\Facades\Facade;

class ClientFacade extends Facade {

    protected static function getFacadeAccessor() { return 'client'; }

}
