<?php

use Illuminate\Database\Migrations\Migration;

class CreateMasterTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        MasterDatabase::createTables();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        MasterDatabase::dropTables();
    }

}
