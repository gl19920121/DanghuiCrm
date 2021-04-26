<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // account password name sex job phone email a_status role_id se_tasks_id re_tasks_id created_at updated_at status
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('account')->unique()->comment('登录账户');
                $table->string('password')->comment('登录密码');
                $table->string('name')->comment('姓名');
                $table->enum('sex', ['男', '女', '其他'])->nullable()->comment('性别');
                $table->string('job')->nullable()->comment('职位');
                $table->string('phone')->nullable()->comment('联系方式');
                $table->string('email')->nullable()->comment('邮箱地址');
                $table->integer('role_id')->comment('账号角色ID')->unsigned();
                $table->rememberToken()->comment('登录状态token'); // 'remember_token' VARCHAR(100) NULL
                $table->timestamps(); // 'create_at' 'update_at'
                $table->tinyInteger('status')->nullable()->default(1)->comment('状态');
                $table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade'); // 外键约束
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
        Schema::dropIfExists('users');
    }
}
