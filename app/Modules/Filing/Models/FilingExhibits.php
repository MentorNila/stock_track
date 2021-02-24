<?php

namespace App\Modules\Filing\Models;

use App\Models\Multitenancy\MultitenancyModel;
use App\Modules\Form\Models\Exhibits;
use Illuminate\Database\Eloquent\Model;

class FilingExhibits extends MultitenancyModel
{

    public $table = 'filing_exhibits';
    public $timestamps = false;

    protected $fillable = [
        'filing_id',
        'exhibit_id',
        'exhibit_name',
        'exhibit_description',
        'exhibit_file_path',
    ];

    public function store($data)
    {
        return FilingExhibits::create($data);
    }

    public function exhibit()
    {
        return $this->belongsTo(Exhibits::class, 'exhibit_id');
    }
}
