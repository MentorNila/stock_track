<?php
namespace App\Modules\Client\Facades;

use Illuminate\Support\Facades\Facade;

class ViewVars extends Facade {

    protected static function getFacadeAccessor() { return 'view-vars'; }

}
