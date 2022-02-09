<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->string('cover')->comment('封面图URL');
            $table->string('brief')->nullable()->comment('简介');
            $table->unsignedInteger('article_types_id')->comment('分类ID');
            $table->unsignedInteger('publisher_id')->comment('发布者用户ID');
            $table->string('publisher_name')->nullable()->comment('发布者');
            $table->mediumText('content')->comment('文章内容HTML');
            $table->unsignedInteger('user_id')->comment('操作用户ID');
            $table->integer('status')->default(1)->comment('状态：0->删除，1->激活');
            $table->timestamps();

            $table->foreign('article_types_id')->references('id')->on('article_types'); // 外键约束
            $table->foreign('publisher_id')->references('id')->onUpdate('cascade')->onDelete('cascade')->on('users'); // 外键约束
            $table->foreign('user_id')->references('id')->onUpdate('cascade')->onDelete('cascade')->on('users'); // 外键约束
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
