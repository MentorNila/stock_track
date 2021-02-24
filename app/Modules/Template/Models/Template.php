<?php

namespace App\Modules\Template\Models;

use App\Modules\Company\Models\Company;
use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Goal\Models\Goal;
use Illuminate\Support\Facades\DB;
use App\Models\Multitenancy\MultitenancyModel;

class Template extends MultitenancyModel
{
    public $table = 'templates';

    protected $fillable = [
        'title',
    ];

    public function getTemplates() {
        $templates = DB::table(Template::getTableName() . ' as u');
        return $templates;
    }
}
