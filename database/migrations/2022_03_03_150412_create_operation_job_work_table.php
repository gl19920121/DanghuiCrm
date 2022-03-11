<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationJobWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_job_work', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('resume_id');
            $table->unsignedInteger('job_id');
            $table->tinyInteger('old_status')->nullable()->comment('状态：-2->审核中，-1->待定，0->淘汰（删除），1->待处理，2->电话沟通，3->推荐简历，4->面试，5->OFFER，6->入职，7->过保，8->结束');
            $table->tinyInteger('status')->comment('状态：-2->审核中，-1->待定，0->淘汰（删除），1->待处理，2->电话沟通，3->推荐简历，4->面试，5->OFFER，6->入职，7->过保，8->结束');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operation_job_work');
    }
}
