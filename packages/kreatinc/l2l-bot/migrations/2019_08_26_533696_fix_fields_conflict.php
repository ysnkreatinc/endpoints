<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


use Kreatinc\Bot\Models\BotType;
use Kreatinc\Bot\Models\LeadField;

class FixFieldsConflict extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        BotType::where('slug', 'general')->first()->fields()->where([
            'type' => 'buyer',
            'entity_key' => 'phone'
        ])->update([
            'position' => 9,
            'question' => 'We are almost done! 👍|What’s your phone number? ☎️'
        ]);
        BotType::where('slug', 'general')->first()->fields()->where([
            'type' => 'seller',
            'entity_key' => 'phone'
        ])->update([
            'position' => 9,
            'question' => 'We are almost done! 👍|What’s your phone number? ☎️'
        ]);

        Schema::table('messages', function (Blueprint $table) {
            $table->longText('body')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->string('body')->change();
        });
    }
}
