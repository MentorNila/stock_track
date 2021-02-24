<?php
namespace App\Modules\Plans\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanForm extends BaseModel
{
    use SoftDeletes;

    protected $primaryKey = null;
    public $incrementing = false;

    protected $table = 'plan_forms';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'plan_id',
        'form_id',
        'price_per_page',
        'price_per_form',
        'is_active',
    ];

}
