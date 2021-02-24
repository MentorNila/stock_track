<?php

use Illuminate\Database\Migrations\Migration;

class CreateTenantsTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        TenantDatabase::createTables();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        TenantDatabase::dropTables();
    }
}
