<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGreetingLoggedInAndOutInBotSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bot_settings', function (Blueprint $table) {
            $table->text('logged_in')->nullable()->after('whitelisted_domains');
            $table->text('logged_out')->nullable()->after('logged_in');
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
            $table->dropColumn('logged_in');
            $table->dropColumn('logged_out');
        });
    }
}
