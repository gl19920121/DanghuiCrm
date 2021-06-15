<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTypeToResumeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE resume_user MODIFY COLUMN type ENUM('seen', 'collect', 'download', 'upload')");
        Schema::table('resume_user', function (Blueprint $table) {
            // $table->enum('type', ['seen', 'collect', 'download', 'upload'])->change();
            $table->unique(['resume_id', 'user_id', 'type', 'created_at'])->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resume_user', function (Blueprint $table) {
            $table->enum('type', ['seen', 'collect'])->change();
            $table->unique(['resume_id', 'user_id', 'type'])->change();
        });
    }
}
