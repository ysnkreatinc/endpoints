<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_accounts', function (Blueprint $table) {
            $table->string('facebook_user_id')->primary();
            $table->string('facebook_first_name')->nullable();
            $table->string('facebook_last_name')->nullable();

            // Agent.
            $table->unsignedInteger('agent_id');
            $table->foreign('agent_id')->references('id')->on('bots')->onDelete('cascade');

            // Token.
            $table->longText('access_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_accounts');
    }
}
