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
                $table->string('name')->comment('角色名');
                $table->string('slug')->unique()->comment('权限等级');
                $table->integer('level')->comment('权限等级');
                $table->boolean('is_root')->default(false);
                $table->unsignedInteger('parent_id')->nullable()->comment('父ID');
                $table->jsonb('permissions')->nullable()->comment('权限列表');
                $table->timestamps();
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
