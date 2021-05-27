<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumeWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_works', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name')->comment('公司名称');
            $table->enum('company_nature', ['foreign', 'joint_venture', 'private', 'state', 'listed', 'government', 'institution', 'other'])->comment('性质');
            $table->integer('company_scale')->comment('规模');
            $table->json('company_industry')->comment('所属行业');
            $table->json('job_type')->comment('职位名称');
            $table->date('start_at')->comment('入职时间');
            $table->date('end_at')->comment('离职时间');
            $table->string('work_desc')->comment('工作描述');
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
