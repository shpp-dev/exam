<?php

use App\Data\ExamSystem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->dateTime('started_at');
            $table->dateTime('finished_at')->nullable();
            $table->boolean('passed')->nullable();
            $table->string('programming_tasks_ids')->nullable();
            $table->integer('programming_status')->default(ExamSystem::DISABLED_STATUS);
            $table->dateTime('programming_started_at')->nullable();
            $table->dateTime('programming_finished_at')->nullable();
            $table->integer('english_status')->default(ExamSystem::DISABLED_STATUS);
            $table->dateTime('english_started_at')->nullable();
            $table->dateTime('english_finished_at')->nullable();
            $table->integer('type_speed_status')->default(ExamSystem::DISABLED_STATUS);
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
        Schema::dropIfExists('exam_sessions');
    }
}
