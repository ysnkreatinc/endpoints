<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSellerIntent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('intents')
            ->where('slug', 'seller')
            ->update(['lead_legend' => 'BOT-S']);

        DB::table('field_choices')
            ->where('text', '$700+k')
            ->update(['text' => '$700k']);
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
