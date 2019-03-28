<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgrammingTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programming_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->unsignedInteger('number');
            $table->text('js_wrap');
            $table->text('java_wrap');
            $table->text('cpp_wrap');
            $table->string('test_cases');
            $table->string('answers');
            $table->string('js_start_function');
            $table->string('java_start_function');
            $table->string('cpp_start_function');
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
        Schema::dropIfExists('tasks');
    }
}
