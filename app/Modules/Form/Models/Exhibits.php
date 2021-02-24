<?php

namespace App\Modules\Form\Models;

use App\Models\Multitenancy\MultitenancyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exhibits extends MultitenancyModel
{

  use SoftDeletes;

  public $table = 'exhibits';

  protected $dates = [
      'created_at',
      'updated_at',
      'deleted_at',
  ];

  protected $fillable = [
      'code',
      'description',
  ];


}
