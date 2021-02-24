<?php namespace App\Models\Multitenancy;

use App\Modules\Client\Models\Client;
use Illuminate\Database\Connection;
use Schema;
use Closure;

class MultitenancySchema {

	protected static $chunk = 200;

	/**
	 * Determine if the given table exists.
	 *
	 * @param  App\Modules\Client\Models\Client  $client
	 * @param  string  $table
	 * @return bool
	 */
	public static function hasTable($client, $table) {
		return Schema::hasTable(MultitenancyModel::getTenantTable($table, $client));
	}

	/**
	 * Determine if the given table has a given column.
	 *
	 * @param  App\Modules\Client\Models\Client  $client
	 * @param  string  $table
	 * @param  string  $column
	 * @return bool
	 */
	public static function hasColumn($client, $table, $column) {
		return Schema::hasColumn(MultitenancyModel::getTenantTable($table, $client), $column);
	}

	/**
	 * Determine if the given table has given columns.
	 *
	 * @param  App\Modules\Client\Models\Client  $client
	 * @param  string  $table
	 * @param  array   $columns
	 * @return bool
	 */
	public static function hasColumns($client, $table, array $columns) {
		return Schema::hasColumns(MultitenancyModel::getTenantTable($table, $client), $columns);
	}

	/**
	 * Get the column listing for a given table.
	 *
	 * @param  App\Modules\Client\Models\Client  $client
	 * @param  string  $table
	 * @return array
	 */
	public static function getColumnListing($client, $table) {
		return Schema::getColumnListing(MultitenancyModel::getTenantTable($table, $client));
	}

	/**
	 * Modify a table on the schema.
	 *
	 * @param  string    $table
	 * @param  \Closure  $callback
	 * @return \Illuminate\Database\Schema\Blueprint
	 */
	public static function table($table, Closure $callback, $clientId = null) {
		$builder = Client::withTrashed()->initedTables();
		if (!is_null($clientId)) {
			$builder->where('id', '=', $clientId);
		}

		$builder->chunk(static::$chunk, function($clients) use ($table, $callback) {
			foreach ($clients as $client) {
				Schema::table(MultitenancyModel::getTenantTable($table, $client), $callback);
			}
		});

	}

	/**
	 * Create a new table on the schema.
	 *
	 * @param  string    $table
	 * @param  \Closure  $callback
	 * @return \Illuminate\Database\Schema\Blueprint
	 */
	public static function create($table, Closure $callback, $clientId = null) {
		$builder = Client::withTrashed()->initedTables();
		if (!is_null($clientId)) {
			$builder->where('id', '=', $clientId);
		}

		$builder->chunk(static::$chunk, function($clients) use ($table, $callback) {
			foreach ($clients as $client) {
				Schema::create(MultitenancyModel::getTenantTable($table, $client), $callback);
			}
		});

	}

	/**
	 * Drop a table from the schema.
	 *
	 * @param  string  $table
	 * @return \Illuminate\Database\Schema\Blueprint
	 */
	public static function drop($table, $clientId = null) {
		$builder = Client::withTrashed()->initedTables();
		if (!is_null($clientId)) {
			$builder->where('id', '=', $clientId);
		}

		$builder->chunk(static::$chunk, function($clients) use ($table) {
			foreach ($clients as $client) {
				Schema::drop(MultitenancyModel::getTenantTable($table, $client));
			}
		});

	}

	/**
	 * Drop a table from the schema if it exists.
	 *
	 * @param  string  $table
	 * @return \Illuminate\Database\Schema\Blueprint
	 */
	public static function dropIfExists($table, $clientId = null) {
		$builder = Client::withTrashed()->initedTables();
		if (!is_null($clientId)) {
			$builder->where('id', '=', $clientId);
		}

		$builder->chunk(static::$chunk, function($clients) use ($table) {
			foreach ($clients as $client) {
				Schema::dropIfExists(MultitenancyModel::getTenantTable($table, $client));
			}
		});

	}

	/**
	 * Rename a table on the schema.
	 *
	 * @param  string  $from
	 * @param  string  $to
	 * @return \Illuminate\Database\Schema\Blueprint
	 */
	public static function rename($from, $to, $clientId = null) {
		$builder = Client::withTrashed()->initedTables();
		if (!is_null($clientId)) {
			$builder->where('id', '=', $clientId);
		}

		$builder->chunk(static::$chunk, function($clients) use ($from, $to) {
			foreach ($clients as $client) {
				Schema::rename(MultitenancyModel::getTenantTable($from, $client), MultitenancyModel::getTenantTable($to, $client));
			}
		});

	}

}
