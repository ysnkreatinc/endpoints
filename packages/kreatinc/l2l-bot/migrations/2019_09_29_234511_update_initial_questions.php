<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInitialQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $types = DB::table('bot_types')->pluck('id', 'slug')->all();

        DB::table('lead_fields')
            ->where('bot_type_id', $types['seller'])
            ->where('entity_key', 'property')
            ->update(['question' => 'Great, let me ask you a few questions to help you sell your home.|What are you selling?']);

        DB::table('lead_fields')
            ->where('bot_type_id', $types['valuation'])
            ->where('entity_key', 'street')
            ->update(['question' => 'Great, let me ask you a few questions to determine your home valuation.|Please type in the street address only (Do not include the city or state).|Eg. ✅ 123 Main Street|❌ 123 Main Street, New York, NY']);

        DB::table('lead_fields')
            ->where('bot_type_id', $types['listing'])
            ->where('entity_key', 'email')
            ->update(['question' => 'Great, please answer a few questions to send you all the details about this property.|Which email address shall we use to notify you? 📧']);

        DB::table('lead_fields')
            ->where('bot_type_id', $types['buyer'])
            ->where('entity_key', 'price')
            ->update(['question' => 'Great, let me ask you a few questions to help you find your perfect home.|Okay! What\'s your preferred price?']);
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
