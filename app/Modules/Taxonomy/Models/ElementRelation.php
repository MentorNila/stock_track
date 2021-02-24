<?php
namespace App\Modules\Taxonomy\Models;

use App\Models\Multitenancy\MultitenancyModel;
use Illuminate\Database\Eloquent\Model;

class ElementRelation extends MultitenancyModel {

    public $table = 'tax_element_relation';
    public $timestamps = false;

    protected $fillable = [
        'element_id',
        'parent_id',
        'file_name',
    ];

    public function store($elementId, $parentId, $filename){
        $data['element_id'] = $elementId;
        $data['parent_id'] = $parentId;
        $data['file_name'] = $filename;
        return ElementRelation::create($data);
    }
}
