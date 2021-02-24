<?php

namespace App\Modules\Role\Models;

use App\Models\Multitenancy\MultitenancyModel;
use App\Modules\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends MultitenancyModel
{
    use SoftDeletes;

    public $table = 'roles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'code',
        'level',
        'agency_level',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, PermissionRole::getTableName());
    }
}
