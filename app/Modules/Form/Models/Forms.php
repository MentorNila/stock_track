<?php

namespace App\Modules\Form\Models;


use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Forms extends BaseModel
{

  use SoftDeletes;

  public $table = 'forms';

  protected $dates = [
      'created_at',
      'updated_at',
      'deleted_at',
  ];

  protected $fillable = [
      'name',
      'type',
  ];


}
