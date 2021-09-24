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
                $table->string('avatar')->nullable()->comment('头像');
                $table->string('name')->comment('姓名');
                $table->boolean('is_show_real_name')->default(true)->comment('是否展示真实姓名');
                $table->enum('sex', ['男', '女', '其他'])->comment('性别');
                $table->integer('age')->comment('年龄');
                $table->date('birthday')->nullable()->comment('生日');
                $table->string('self_introduction')->nullable()->comment('自我介绍');
                $table->json('location')->comment('所在城市');
                $table->integer('work_years_flag')->comment('工作年限标识');
                $table->integer('work_years')->nullable()->comment('工作年限');
                $table->date('work_at')->nullable()->comment('参加工作时间');
                $table->enum('education', ['unlimited', 'high_schoo', 'junior', 'undergraduate', 'master', 'doctor'])->comment('教育程度');
                $table->string('major')->nullable()->comment('所学专业');
                $table->string('phone_num')->comment('手机号');
                $table->string('email')->comment('邮箱');
                $table->string('wechat')->nullable()->comment('微信');
                $table->string('qq')->nullable()->comment('QQ');
                $table->json('cur_industry')->nullable()->comment('所在行业');
                $table->json('cur_position')->nullable()->comment('所任职位');
                $table->string('cur_company')->nullable()->comment('所在公司');
                $table->float('cur_salary', 8, 1)->nullable()->comment('目前月薪');
                $table->integer('cur_salary_count')->nullable()->default(12)->comment('目前月薪');
                $table->json('exp_industry')->nullable()->comment('期望行业');
                $table->json('exp_position')->comment('期望职位');
                $table->enum('exp_work_nature', ['full', 'part', 'all'])->nullable()->comment('工作性质');
                $table->json('exp_location')->comment('期望城市');
                $table->integer('exp_salary_flag')->comment('期望薪资标识');
                $table->float('exp_salary_min', 8, 1)->nullable()->comment('期望薪资');
                $table->float('exp_salary_max', 8, 1)->nullable()->comment('期望薪资');
                $table->integer('exp_salary_count')->nullable()->default(12)->comment('期望薪资');
                $table->integer('jobhunter_status')->nullable()->comment('求职者状态');
                $table->string('social_home')->nullable()->comment('社交主页');
                $table->string('personal_advantage')->nullable()->comment('个人优势');
                $table->string('blacklist')->nullable()->comment('屏蔽公司');
                $table->string('remark')->nullable()->comment('其他备注');
                $table->json('source')->comment('来源渠道');
                $table->string('source_remarks')->nullable()->comment('来源渠道备注');
                $table->string('upload_uid')->comment('上传人ID');
                $table->string('attachment_path')->nullable()->comment('简历文件路径');
                $table->integer('job_id')->nullable()->comment('职位id')->unsigned();
                $table->dateTime('deliver_at')->nullable()->comment('投递时间');
                $table->integer('is_collect')->default(0)->comment('收藏状态');
                $table->timestamps();
                $table->integer('status')->default(1)->comment('状态：-2->审核中，-1->待定，0->淘汰（删除），1->待处理，2->电话沟通，3->推荐简历，4->面试，5->OFFER，6->入职，7->过保，8->结束');
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
