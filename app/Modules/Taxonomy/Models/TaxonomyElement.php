<?php

namespace App\Modules\Taxonomy\Models;

use App\Models\Multitenancy\MultitenancyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxonomyElement extends MultitenancyModel
{
    use SoftDeletes;

    public $table = 'taxonomy_elements';

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'name',
        'abstract',
        'nillable',
        'type',
        'substitutionGroup',
        'periodType',
        'namespace',
        'balance',
        'documentation',
        'label',
    ];

    public function store($data){
        return TaxonomyElement::create($data);
    }

    public function getTagByName($name){
        $tag = static::where('name',$name)->first();
        if ($tag){
            return $tag;
        } else {
            $tag = ExtensionTaxonomy::where('name',$name)->first();
            if ($tag){
                return $tag;
            } else {
                return null;
            }
        }
    }
}
