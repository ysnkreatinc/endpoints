<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kreatinc\Bot\Models\BotType;
use Kreatinc\Bot\Models\LeadField;

class RemoveQuestionInGeneralBuyerBot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        BotType::where('slug', 'general')->first()->fields()->where('entity_key', 'visit_home')->delete();
        BotType::where('slug', 'general')->first()->fields()->where('entity_key', 'visit_home_time')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $generalBot = BotType::where('slug', 'general')->first();

        LeadField::onlyTrashed()->where([
            'type'        => 'buyer',
            'bot_type_id' => $generalBot->id,
            'entity_key'  => 'visit_home',
        ])->restore();
        LeadField::onlyTrashed()->where([
            'type'        => 'buyer',
            'bot_type_id' => $generalBot->id,
            'entity_key'  => 'visit_home_time',
        ])->restore();
    }
}
