<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Kreatinc\Bot\Models\BotType;

class UpdateSellerBotPropertyChoiceText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update property in seller bot.
        BotType::where('slug', 'seller')
            ->first()
            ->fields()
            ->where('entity_key', 'property')
            ->first()
            ->fieldChoices()
            ->where('text', 'Residence')
            ->update([
                'text'    => 'Single Family Home',
                'payload' => 'Single Family Home',
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Restore property in seller bot.
        BotType::where('slug', 'seller')
            ->first()
            ->fields()
            ->where('entity_key', 'property')
            ->first()
            ->fieldChoices()
            ->where('text', 'Single Family Home')
            ->update([
                'text'    => 'Residence',
                'payload' => 'Residence',
            ]);
    }
}
