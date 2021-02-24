<?php

namespace App\Modules\Filing\Models;

use App\Models\Multitenancy\MultitenancyModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class FilingTag extends MultitenancyModel
{
    use SoftDeletes;

    public $table = 'filing_tags';

    protected $fillable = [
        'filing_id',
        'attributes'
    ];

    protected $casts = [
        'attributes' => 'array'
    ];

    public function store($filingId, $tags = null){
        $data['filing_id'] = $filingId;
        $data['attributes'] = $tags;

        return FilingTag::create($data);
    }
}
