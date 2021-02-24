<?php

namespace App\Modules\Taxonomy\Models;

use App\Models\Multitenancy\MultitenancyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExtensionTaxonomy extends MultitenancyModel
{
    use SoftDeletes;

    public $table = 'extension_taxonomy';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'filing_id',
        'code',
        'label',
        'name',
        'abstract',
        'type',
        'nillable',
        'substitutionGroup',
        'periodType',
        'namespace',
        'balance',
        'documentation',
    ];

    public function getTagByName($name)
    {
        return static::select('abstract', 'code', 'name', 'nillable', 'substitutionGroup', 'type', 'balance as xbrli:balance', 'periodType as xbrli:periodType')->where('name', $name)->first();
    }
}
