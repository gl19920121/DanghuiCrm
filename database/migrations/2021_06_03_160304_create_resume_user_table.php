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
            $table->integer('resume_id')->comment('简历id');
            $table->integer('user_id')->comment('用户id');
            $table->enum('type', ['seen', 'collect'])->comment('操作行为');
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
        Schema::dropIfExists('resume_user');
    }
}
