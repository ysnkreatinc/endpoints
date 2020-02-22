<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

use Kreatinc\Bot\Models\BotType;
use Kreatinc\Bot\Models\LeadField;

class UpdateHomeValuationQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Change phone and schedule order and data.
        foreach (['general', 'valuation'] as $type) {
            $botType = BotType::where('slug', $type)->first();

            $botType->fields()->where('entity_key', 'phone')->update([
                'question' => 'As we have a wide range for the value estimate of your home|And that every home is unique|Let\'s chat about your home’s actual value in today\'s market.|Is this the best way to get a hold of you :email: or would you prefer a quick phone call or text?',
            ]);
        }

        $botType = BotType::where('slug', 'listing')->first();

        $botType->fields()->where('entity_key', 'visit_home')->update([
            'question' => 'Would you like to see this home?',
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
