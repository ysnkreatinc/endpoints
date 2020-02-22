<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Kreatinc\Bot\Models\BotType;

class UpdatePhoneQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Change phone and schedule order and data.
        $botType = BotType::where('slug', 'general')->first();

        $botType->fields()
            ->whereIn('type', ['buyer','seller'])
            ->where('entity_key', 'phone')
            ->update([
                'question' => 'We are almost done! 👍|What’s your phone number? ☎️',
            ]);

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
