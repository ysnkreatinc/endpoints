<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWhitelistedDomainsInBotSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bot_settings', function (Blueprint $table) {
            $table->longText('whitelisted_domains')->after('ask_again')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bot_settings', function (Blueprint $table) {
            $table->dropColumn('whitelisted_domains');
        });
    }
}
