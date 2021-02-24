<?php namespace App\Models\Multitenancy;


use App\Models\Base\BaseModel;
use App\Modules\Client\Models\Client;

class MultitenancyModel extends BaseModel {

	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);


        $this->setTable(static::getTenantTable($this->getTable()));
	}

	public static function getTenantTable($table, $client = null) {
		if (is_null($client)) {
			$client = Client::getCurrentClient();
		}

		if (is_null($client)) {
			// artisan command comes into here
			return;
		}

		return static::genTenantPrefix($client->id) . $table;
	}

	public static function genTenantPrefix($clientId) {
		return empty($clientId) ? '' : '_' . $clientId . '__';
	}

}
