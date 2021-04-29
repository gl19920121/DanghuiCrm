<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('resumes')) {
            Schema::create('resumes', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->comment('姓名');
                $table->enum('sex', ['男', '女', '其他'])->comment('性别');
                $table->integer('age')->comment('年龄');
                $table->string('city')->comment('所在城市');
                $table->integer('work_years_flag')->comment('工作年限标识');
                $table->integer('work_years')->nullable()->comment('工作年限');
                $table->string('education')->comment('教育程度');
                $table->string('phone_num', 11)->comment('手机号');
                $table->string('email')->comment('邮箱');
                $table->string('wechat_or_qq')->comment('微信/QQ');
                $table->string('cur_industry')->comment('所在行业');
                $table->string('cur_position')->comment('所任职位');
                $table->string('cur_company')->comment('所在公司');
                $table->integer('cur_salary')->comment('目前月薪');
                $table->string('exp_industry')->comment('期望行业');
                $table->string('exp_position')->comment('期望职位');
                $table->string('exp_work_nature')->comment('工作性质');
                $table->string('exp_city')->comment('期望城市');
                $table->integer('exp_salary_flag')->comment('期望薪资标识');
                $table->integer('exp_salary')->nullable()->comment('期望薪资');
                $table->integer('jobhunter_status')->comment('求职者状态');
                $table->integer('source')->comment('来源渠道');
                $table->string('source_remarks')->nullable()->comment('来源渠道备注');
                $table->integer('upload_uid')->comment('上传人ID');
                $table->string('attachment_path')->comment('简历文件路径');
                $table->integer('job_id')->nullable()->comment('职位id')->unsigned();
                $table->timestamps();
                $table->integer('status')->nullable()->default(1)->comment('状态');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resumes');
    }
}
