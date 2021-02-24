<?php

use App\Models\Multitenancy\MultitenancySchema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResolvedToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        MultitenancySchema::table('comments', function (Blueprint $table) {
            $table->boolean('resolved')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        MultitenancySchema::table('comments', function (Blueprint $table) {
            $table->dropColumn('resolved');
        });
    }
}
