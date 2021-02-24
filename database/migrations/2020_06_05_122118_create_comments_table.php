<?php

use App\Models\Multitenancy\MultitenancySchema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        MultitenancySchema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('filing_id');
            $table->integer('user_id');
            $table->integer('parent_id');
            $table->longText('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        MultitenancySchema::dropIfExists('comments');
    }
}
