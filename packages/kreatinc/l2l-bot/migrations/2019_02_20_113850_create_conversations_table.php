<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->string('step')->nullable();
            $table->string('next')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('paused_at')->nullable();
            $table->boolean('completed')->default(false);

            $table->integer('lead_client_id')->unsigned()->nullable();
            $table->foreign('lead_client_id')->references('id')->on('lead_clients');
            $table->integer('page_id')->unsigned()->nullable();
            $table->foreign('page_id')->references('id')->on('pages');

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
        Schema::dropIfExists('conversations');
    }
}
