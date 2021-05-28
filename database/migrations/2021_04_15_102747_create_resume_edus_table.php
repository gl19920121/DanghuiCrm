<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumeEdusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_edus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('school_name')->comment('毕业院校');
            $table->enum('school_level', ['unlimited', 'high_schoo', 'junior', 'undergraduate', 'master', 'doctor'])->comment('最高学历');
            $table->string('major')->nullable()->comment('所学专业');
            $table->date('start_at')->comment('入学时间');
            $table->date('end_at')->nullable()->comment('毕业时间');
            $table->integer('is_end')->nullable()->default(1)->comment('是否结束');
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
        Schema::dropIfExists('resume_edu');
    }
}
