<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->string('nickname')->comment('对外显示名称');
            $table->json('industry')->comment('所属行业');
            $table->json('location')->comment('所在地');
            $table->string('address')->comment('公司详细地址');
            $table->enum('nature', ['foreign', 'joint_venture', 'private', 'state', 'listed', 'government', 'institution', 'other'])->comment('性质');
            $table->integer('scale')->comment('规模');
            $table->enum('investment', ['angel', 'round_a', 'round_b', 'round_c', 'round_d_and_above', 'fuk', 'strategic', 'undisclosed', 'not_needed', 'other'])->nullable()->comment('融资阶段');
            $table->string('logo')->comment('标志');
            $table->string('introduction')->comment('介绍');
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
        Schema::dropIfExists('companys');
    }
}