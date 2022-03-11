<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quota')->nullable()->comment('招聘人数');
            $table->string('name')->comment('职位名称');
            $table->json('type')->comment('职位类别');
            $table->enum('nature', ['full', 'part', 'all'])->comment('工作性质');
            $table->json('location')->comment('工作地点');
            $table->integer('salary_min')->comment('最低税前月薪');
            $table->integer('salary_max')->comment('最高税前月薪');
            $table->integer('salary_count')->nullable()->default(12)->comment('月薪数');
            $table->enum('welfare', ['social_insurance', 'five_social_insurance_and_one_housing_fund', 'four_social_insurance_and_one_housing_fund'])->comment('福利待遇');
            $table->string('sparkle')->nullable()->comment('职位亮点');
            $table->integer('age_min')->comment('最低年龄');
            $table->integer('age_max')->comment('最高年龄');
            $table->enum('education', ['unlimited', 'high_schoo', 'junior', 'undergraduate', 'master', 'doctor'])->comment('学历要求');
            $table->enum('experience', ['unlimited', 'school', 'fresh_graduates', 'primary', 'middle', 'high', 'expert'])->comment('经验要求');
            $table->text('duty')->comment('工作职责');
            $table->text('requirement')->comment('任职要求');
            $table->integer('urgency_level')->comment('紧急程度');
            $table->json('channel')->comment('渠道选择');
            $table->string('channel_remark')->nullable()->comment('渠道平台备注');
            $table->date('deadline')->comment('截止日期');
            $table->integer('pv')->nullable()->default(0)->comment('访问量');
            $table->integer('release_uid')->comment('职位发布人')->unsigned();
            $table->integer('execute_uid')->nullable()->comment('职位执行人')->unsigned();
            $table->integer('company_id')->comment('公司id')->unsigned();
            $table->timestamps();
            $table->tinyInteger('status')->nullable()->default(-1)->comment('状态：-1->审核中，0->结束（删除），1->进行中，2->暂停');
            $table->foreign('release_uid')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade'); // 外键约束
            $table->foreign('execute_uid')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade'); // 外键约束
            $table->foreign('company_id')->references('id')->on('companies')->onUpdate('cascade')->onDelete('cascade'); // 外键约束
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
