<?php
namespace App\Modules\Plans\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends BaseModel
{
    use SoftDeletes;

    protected $table = 'plans';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'description',
        'price',
        'company_number',
    ];

}
