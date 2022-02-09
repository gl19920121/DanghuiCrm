<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no')->comment('编号');
            $table->string('type')->comment('分类');
            $table->integer('level')->comment('等级');
            $table->string('name')->comment('分类名');
            $table->string('pno')->nullable()->comment('父编号');
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
        Schema::dropIfExists('article_types');
    }
}
