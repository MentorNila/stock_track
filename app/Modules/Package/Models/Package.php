<?php
namespace App\Modules\Package\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends BaseModel
{
    use SoftDeletes;

    protected $table = 'packages';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'nr_of_employees',
        'description',
        'price',
        'company_number',
    ];

}
