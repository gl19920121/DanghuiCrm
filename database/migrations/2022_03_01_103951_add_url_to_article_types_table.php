<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlToArticleTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_types', function (Blueprint $table) {
            if (!Schema::hasColumn('article_types', 'url')) {
                $table->string('url')->nullable()->comment('子地址');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_types', function (Blueprint $table) {
            if (Schema::hasColumn('article_types', 'url')) {
                $table->drop_column('url');
            }
        });
    }
}
