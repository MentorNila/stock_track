<?php

namespace App\Modules\Permission\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends BaseModel
{
    use SoftDeletes;

    public $table = 'permissions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
