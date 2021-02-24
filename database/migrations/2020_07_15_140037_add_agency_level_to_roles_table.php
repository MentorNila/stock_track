<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAgencyLevelToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Multitenancy\MultitenancySchema::table('roles', function (Blueprint $table) {
            $table->boolean('agency_level')->default(0)->after('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\Multitenancy\MultitenancySchema::table('roles', function (Blueprint $table) {
            $table->dropColumn('agency_level');
        });
    }
}
