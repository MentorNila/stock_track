<?php

use App\Modules\Client\Classes\ClientStatusCode;
use App\Modules\Client\Models\Client;
use App\Modules\Package\Models\Package;
use Illuminate\Database\Schema\Blueprint;
use Carbon\Carbon;

class MasterDatabase {

    /**
     * Create tables for master
     *
     * @param int $clientId
     */
    public static function createTables() {
        Schema::create('clients', function(Blueprint $table) {
            $table->increments('id');
            $table->string('subdomain', 100)->unique();
            $table->string('name', 200);
            $table->string('active_key', 200)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamp('active_date')->nullable();
            $table->timestamp('expired_date')->nullable();
            $table->unsignedInteger('admin_id')->nullable();
            $table->tinyInteger('plan_id')->default(1)->nullable();
            $table->tinyInteger('package_id')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Client::create([
            'subdomain' => '',
            'name' => 'Default',
            'status' => ClientStatusCode::$ACTIVATED,
            'active_date' => Carbon::now(),
        ]);
        Client::create([
            'subdomain' => 'rln',
            'name' => 'RLN US LLP',
            'status' => ClientStatusCode::$ACTIVATED,
            'active_date' => Carbon::now(),
        ]);

        Schema::create('client_admin', function(Blueprint $table) {
            $table->increments('id');
            $table->string('username', 50);
            $table->string('password', 60);
            $table->tinyInteger('gender');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('company', 100)->nullable();
            $table->string('title', 100)->nullable();
            $table->string('email', 200);
            $table->string('telephone', 100)->nullable();
            $table->integer('country_id')->unsigned();
            $table->string('language_code', 2);
            $table->string('contact_name', 100)->nullable();
            $table->string('contact_email', 200)->nullable();
            $table->string('customer_number', 100)->nullable();
            $table->integer('status')->default(0);
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('plans', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('description', 250);
            $table->string('price');
            $table->integer('company_number');
            $table->boolean('is_public')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('packages', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('nr_of_employees', 100);
            $table->string('description', 250);
            $table->string('price');
            $table->boolean('is_public')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
        
        Package::insert([
            'id' => 1,
            'title' => '25',
            'nr_of_employees' => '25',
            'description' => 'description',
            'price' => 50
        ]);
        Package::insert([
            'id' => 2,
            'title' => '50',
            'nr_of_employees' => '50',
            'description' => 'description',
            'price' => 50
        ]);
        Package::insert([
            'id' => 3,
            'title' => '100',
            'nr_of_employees' => '100',
            'description' => 'description',
            'price' => 50
        ]);

        Schema::create('forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('plan_forms', function (Blueprint $table) {
            $table->integer('plan_id');
            $table->integer('form_id');
            $table->string('price_per_page');
            $table->string('price_per_form');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
        });

        (new FormsTableSeeder())->run();

        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('clients_requests', function(Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 200);
            $table->string('last_name', 200);
            $table->string('email', 200);
            $table->string('phone_number', 200);
            $table->string('company', 200);
            $table->string('job_title', 200);
            $table->string('country', 200);
            $table->string('method_of_contact', 200);
            $table->tinyInteger('status')->default(0);
            $table->text('request')->nullable();
            $table->tinyInteger('plan_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Drop tables for master
     *
     * @param int $clientId
     */
    public static function dropTables()
    {
        Schema::drop('client_admin');
        Schema::drop('permissions');
        Schema::drop('clients');
        Schema::drop('plans');
        Schema::drop('forms');
        Schema::drop('plan_forms');
        Schema::drop('clients_requests');
    }

}
