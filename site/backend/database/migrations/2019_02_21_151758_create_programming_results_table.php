<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgrammingResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programming_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('session_id');
            $table->unsignedInteger('task_number');
            $table->unsignedInteger('task_id');
            $table->text('result');
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
        Schema::dropIfExists('programming_results');
    }
}
