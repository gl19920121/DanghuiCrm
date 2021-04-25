<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('job_name')->comment('职位名');
            $table->integer('release_uid')->comment('职位任务发布人')->unsigned();
            $table->integer('execute_uid')->nullable()->comment('职位任务执行人')->unsigned();
            $table->timestamps();
            $table->tinyInteger('status')->nullable()->default(1)->comment('状态');
            $table->foreign('release_uid')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade'); // 外键约束
            $table->foreign('execute_uid')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade'); // 外键约束
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_tasks');
    }
}
