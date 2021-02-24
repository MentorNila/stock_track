<?php namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

	/**
	 * {@inheritdoc}
	 */
	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
	}

	public static function getTableName() {
		return (new static)->getTable();
	}

}
