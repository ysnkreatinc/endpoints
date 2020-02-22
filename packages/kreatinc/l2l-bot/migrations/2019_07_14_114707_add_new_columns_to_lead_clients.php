<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToLeadClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_clients', function (Blueprint $table) {
            $table->unsignedInteger('bot_id')->nullable()->after('account_id');
            $table->foreign('bot_id')->references('id')->on('bots');

            $table->string('address')->nullable()->after('phone');
            $table->string('type')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lead_clients', function (Blueprint $table) {
            $table->dropForeign(['bot_id']);
            $table->dropColumn('bot_id');
            $table->dropColumn('address');
            $table->dropColumn('type');
        });
    }
}
