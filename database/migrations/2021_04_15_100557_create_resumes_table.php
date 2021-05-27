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
                $table->json('location')->comment('所在城市');
                $table->integer('work_years_flag')->comment('工作年限标识');
                $table->integer('work_years')->nullable()->comment('工作年限');
                $table->enum('education', ['unlimited', 'high_schoo', 'junior', 'undergraduate', 'master', 'doctor'])->comment('教育程度');
                $table->string('major')->nullable()->comment('所学专业');
                $table->string('phone_num')->comment('手机号');
                $table->string('email')->comment('邮箱');
                $table->string('wechat')->comment('微信');
                $table->string('qq')->comment('QQ');
                $table->json('cur_industry')->comment('所在行业');
                $table->json('cur_position')->comment('所任职位');
                $table->string('cur_company')->comment('所在公司');
                $table->integer('cur_salary')->comment('目前月薪');
                $table->integer('cur_salary_count')->comment('目前月薪');
                $table->json('exp_industry')->comment('期望行业');
                $table->json('exp_position')->comment('期望职位');
                $table->enum('exp_work_nature', ['full', 'part', 'all'])->comment('工作性质');
                $table->json('exp_location')->comment('期望城市');
                $table->integer('exp_salary_flag')->comment('期望薪资标识');
                $table->integer('exp_salary_min')->nullable()->comment('期望薪资');
                $table->integer('exp_salary_max')->nullable()->comment('期望薪资');
                $table->integer('exp_salary_count')->nullable()->comment('期望薪资');
                $table->integer('jobhunter_status')->comment('求职者状态');
                $table->string('social_home')->nullable()->comment('社交主页');
                $table->string('personal_advantage')->nullable()->comment('个人优势');
                $table->string('blacklist')->nullable()->comment('屏蔽公司');
                $table->string('remark')->nullable()->comment('其他备注');
                $table->json('source')->comment('来源渠道');
                $table->string('source_remarks')->nullable()->comment('来源渠道备注');
                $table->integer('upload_uid')->comment('上传人ID');
                $table->string('attachment_path')->comment('简历文件路径');
                $table->integer('job_id')->nullable()->comment('职位id')->unsigned();
                $table->timestamps();
                $table->integer('status')->nullable()->default(1)->comment('状态');
                $table->foreign('job_id')->references('id')->on('jobs')->onUpdate('cascade')->onDelete('set null'); // 外键约束
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
