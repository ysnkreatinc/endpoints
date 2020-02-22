<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kreatinc\Bot\Models\LeadField;
use Kreatinc\Bot\Models\BotType;

class ChangesToValuationConversation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Street
        LeadField::where([
            'type'       => 'valuation',
            'entity_key' => 'address'
        ])->update([
            'entity_key'  => 'street',
            'entity_type' => '',
            'title'       => 'Street',
            'question'    => 'Please type in the street address only (Do not include the city or state).|eg. ✅ 523 Margaret Ct|❌ 523 Margaret Ct, Layton, Utah',
        ]);

        // Zipcode
        $zipcode = [
            'type'        => 'valuation',
            'title'       => 'Zip code',
            'entity_key'  => 'zipcode',
            'entity_type' => '',
            'question'    => 'Thank you. Now just type in the Zip code.',
            'position'    => 2,
        ];
        BotType::where('slug', 'general')->first()->fields()->create($zipcode);
        BotType::where('slug', 'valuation')->first()->fields()->create($zipcode);

        // Update position for valuation fields.
        BotType::where('slug', 'general')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'street'])->update(['position' => 1]);
        BotType::where('slug', 'general')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'zipcode'])->update(['position' => 2]);
        BotType::where('slug', 'general')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'email'])->update(['position' => 3]);
        BotType::where('slug', 'general')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'phone'])->update(['position' => 4]);
        BotType::where('slug', 'general')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'schedule'])->update(['position' => 5]);
        BotType::where('slug', 'general')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'visit_date'])->update(['position' => 6]);

        // Update position for valuation fields.
        BotType::where('slug', 'valuation')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'street'])->update(['position' => 1]);
        BotType::where('slug', 'valuation')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'zipcode'])->update(['position' => 2]);
        BotType::where('slug', 'valuation')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'email'])->update(['position' => 3]);
        BotType::where('slug', 'valuation')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'phone'])->update(['position' => 4]);
        BotType::where('slug', 'valuation')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'schedule'])->update(['position' => 5]);
        BotType::where('slug', 'valuation')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'visit_date'])->update(['position' => 6]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Street
        LeadField::where([
            'type'       => 'valuation',
            'entity_key' => 'street'
        ])->update([
            'entity_key'  => 'address',
            'entity_type' => 'location',
            'title'       => 'Home Address',
            'question'    => 'What is your property address?|Eg. 123 Main Street, New York, NY|Eg. 123 Main Street, 95630',
        ]);

        // Zipcode
        LeadField::where([
            'type'       => 'valuation',
            'entity_key' => 'zipcode',
        ])->delete();

        // Position for general
        BotType::where('slug', 'general')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'address'])->update(['position' => 1]);
        BotType::where('slug', 'general')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'email'])->update(['position' => 2]);
        BotType::where('slug', 'general')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'phone'])->update(['position' => 3]);
        BotType::where('slug', 'general')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'schedule'])->update(['position' => 4]);
        BotType::where('slug', 'general')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'visit_date'])->update(['position' => 5]);

        // Position for valuation
        BotType::where('slug', 'valuation')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'address'])->update(['position' => 1]);
        BotType::where('slug', 'valuation')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'email'])->update(['position' => 2]);
        BotType::where('slug', 'valuation')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'phone'])->update(['position' => 3]);
        BotType::where('slug', 'valuation')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'schedule'])->update(['position' => 4]);
        BotType::where('slug', 'valuation')->first()->fields()->where(['type' => 'valuation', 'entity_key' => 'visit_date'])->update(['position' => 5]);
    }
}

