<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Kreatinc\Bot\Models\BotType;
use Kreatinc\Bot\Models\LeadField;

class RemovePhoneQuestionFromListingBot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        BotType::where('slug', 'listing')->first()->fields()->where('entity_key', 'phone')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $listingBot = BotType::where('slug', 'listing')->first();

        LeadField::onlyTrashed()->where([
            'type'        => 'buyer',
            'bot_type_id' => $listingBot->id,
            'entity_key'  => 'phone',
        ])->restore();
    }
}
