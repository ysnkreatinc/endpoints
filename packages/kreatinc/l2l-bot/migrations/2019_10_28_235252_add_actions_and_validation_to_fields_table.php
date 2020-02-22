<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActionsAndValidationToFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_fields', function (Blueprint $table) {
            $table->string('validation')->nullable();
            $table->string('actions')->nullable();
            // Store raw value and not from wit
            $table->boolean('store_raw_value')->default(false);
            $table->boolean('is_hidden')->default(false);
        });

        Schema::table('lead_data', function (Blueprint $table) {
            $table->dropForeign(['lead_field_id']);
        });

        Schema::table('bot_intents', function (Blueprint $table) {
            $table->boolean('in_menu')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 
    }
}
