<?php

use App\Models\Multitenancy\MultitenancySchema;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class DropUniqueCodeAtRolesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        MultitenancySchema::table('roles', function (Blueprint $table) {
            $table->string('code')->unique(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
