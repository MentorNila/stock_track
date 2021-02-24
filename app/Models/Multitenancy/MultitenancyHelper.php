<?php namespace App\Models\Multitenancy;
use App\Modules\Client\Models\Client;

class MultitenancyHelper {

	public static function run(callable $callback, $clientId = null)
	{
		$originClient = Client::getCurrentClient();

		$builder = Client::withTrashed()->initedTables();
		if (!is_null($clientId)) {
			$builder->where('id', '=', $clientId);
		}
		$clients = $builder->get();
		foreach ($clients as $client) {
			Client::setCurrentClient($client);
			call_user_func($callback, $client);
		}

		Client::setCurrentClient($originClient);
	}

}
