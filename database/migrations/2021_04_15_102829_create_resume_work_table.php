<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumeWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_work', function (Blueprint $table) {
            $table->increments('id');
            $table->string('body')->comment('工作经历内容');
            $table->integer('resume_id')->comment('所属简历ID')->unsigned();
            $table->timestamps();
            $table->foreign('resume_id')->references('id')->on('resumes')->onUpdate('cascade')->onDelete('cascade'); // 外键约束
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resume_work');
    }
}
