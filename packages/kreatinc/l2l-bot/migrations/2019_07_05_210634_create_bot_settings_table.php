<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_settings', function (Blueprint $table) {
            $table->unsignedInteger('bot_id')->primary();
            $table->foreign('bot_id')->references('id')->on('bots')->onDelete('cascade');

            $table->boolean('presistent_menu')->default(true);
            $table->boolean('home_valuation')->default(true);
            $table->boolean('listings_suggestions')->default(true);
            $table->boolean('ask_again')->default(true);
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
        Schema::dropIfExists('bot_settings');
    }
}
