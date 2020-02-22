<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBotTypeIdInLeadFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_fields', function (Blueprint $table) {
            $table->unsignedBigInteger('bot_type_id')->nullable()->after('type');
            $table->foreign('bot_type_id')->references('id')->on('bot_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lead_fields', function (Blueprint $table) {
            $table->dropForeign(['bot_type_id']);
            $table->dropColumn('bot_type_id');
        });
    }
}
