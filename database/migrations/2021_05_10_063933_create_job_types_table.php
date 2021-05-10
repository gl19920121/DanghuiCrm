<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no')->comment('编号');
            $table->string('name')->comment('中文名称');
            $table->string('en_name')->comment('英文名称');
            $table->string('pno')->comment('父编号');
            $table->integer('level')->comment('等级');
            $table->timestamps();
            $table->tinyInteger('status')->nullable()->default(1)->comment('状态');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_types');
    }
}
