<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumePrjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_prjs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('项目名称');
            $table->string('role')->nullable()->comment('担任角色');
            $table->date('start_at')->nullable()->comment('开始时间');
            $table->date('end_at')->nullable()->comment('结束时间');
            $table->integer('is_not_end')->nullable()->default(0)->comment('是否结束');
            $table->string('body')->nullable()->comment('项目内容');
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
        Schema::dropIfExists('resume_prj');
    }
}
