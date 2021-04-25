<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('role_name')->unique()->comment('角色名');
                $table->string('level')->comment('权限等级');
                $table->json('permission')->comment('权限列表');
                $table->timestamps(); // 'create_at' 'update_at'
                $table->tinyInteger('status')->nullable()->default(1)->comment('状态');
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
        Schema::dropIfExists('roles');
    }
}
