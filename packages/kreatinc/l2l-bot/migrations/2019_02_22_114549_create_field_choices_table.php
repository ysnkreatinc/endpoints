<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_choices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->default('text'); // text - phone - email - location
            $table->string('text');
            $table->string('payload');

            $table->integer('lead_field_id')->unsigned();
            $table->foreign('lead_field_id')->references('id')->on('lead_fields');

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
        Schema::dropIfExists('field_choices');
    }
}
