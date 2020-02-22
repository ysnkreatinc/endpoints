<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bots', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(true);
            $table->string('title');

            // Member ID
            // This needed so we can identify the bot by Listings To Leads user ID.
            $table->integer('l2l_member_id');
            $table->integer('listing_id')->nullable();

            // Type
            $table->unsignedBigInteger('bot_type_id');
            $table->foreign('bot_type_id')->references('id')->on('bot_types')->onDelete('cascade');

            // Page
            $table->unsignedInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');

            $table->string('greeting_text');
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
        Schema::dropIfExists('bots');
    }
}
