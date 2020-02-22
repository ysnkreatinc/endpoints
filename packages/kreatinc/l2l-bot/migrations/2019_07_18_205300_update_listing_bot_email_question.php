<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Kreatinc\Bot\Models\BotType;

class UpdateListingBotEmailQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update email in listing bot.
        BotType::where('slug', 'listing')
            ->first()
            ->fields()
            ->where('entity_key', 'email')
            ->update([
                'question' => 'Which email address shall we use to notify you? 📧'
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Restore email in listing bot.
        BotType::where('slug', 'listing')
            ->first()
            ->fields()
            ->where('entity_key', 'email')
            ->update([
                'question' => 'Which email address shall we use to notify you?'
            ]);
    }
}
