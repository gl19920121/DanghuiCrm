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
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->string('nickname')->nullable()->comment('对外显示名称');
            $table->json('industry')->nullable()->comment('所属行业');
            $table->json('location')->comment('所在地');
            $table->string('address')->nullable()->comment('公司详细地址');
            $table->enum('nature', ['foreign', 'joint_venture', 'private', 'state', 'listed', 'government', 'institution', 'other'])->nullable()->comment('性质');
            $table->integer('scale')->nullable()->comment('规模');
            $table->enum('investment', ['angel', 'round_a', 'round_b', 'round_c', 'round_d_and_above', 'fuk', 'strategic', 'undisclosed', 'not_needed', 'other'])->nullable()->comment('融资阶段');
            $table->string('logo')->nullable()->comment('标志');
            $table->text('introduction')->nullable()->comment('介绍');
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
