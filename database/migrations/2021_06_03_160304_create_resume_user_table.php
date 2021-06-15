<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('resume_id')->comment('简历id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->enum('type', ['seen', 'collect', 'download', 'upload', 'repeat', 'accept'])->comment('操作行为');
            $table->integer('times')->nullable()->comment('操作次数');
            $table->timestamps();

            $table->unique(['resume_id', 'user_id', 'type']);
            $table->foreign('resume_id')->references('id')->on('resumes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resume_user');
    }
}
