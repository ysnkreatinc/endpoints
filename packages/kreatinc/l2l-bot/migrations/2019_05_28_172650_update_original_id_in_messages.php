<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOriginalIdInMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->string('original_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Update NULL original_id to empty string before we rollback.
        DB::statement('UPDATE `messages` SET `original_id` = \'\' WHERE `original_id` IS NULL;');

        Schema::table('messages', function (Blueprint $table) {
            $table->string('original_id')->nullable(false)->change();
        });
    }
}
