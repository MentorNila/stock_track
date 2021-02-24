<?php

namespace App\Modules\Role\Models;

use App\Models\Multitenancy\MultitenancyModel;

class PermissionRole extends MultitenancyModel
{
    public $table = 'permission_role';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'role_id',
        'permission_id',
    ];
}
