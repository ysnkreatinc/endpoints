<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
use Kreatinc\Bot\Models\BotType;
use Kreatinc\Bot\Models\Page;
use Kreatinc\Bot\Models\LeadField;

class AddDefaultBotType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $botTypes = [
            ['name' => 'General Bot','slug' => 'general'],
            ['name' => 'Listing Bot', 'slug' => 'listing'],
            ['name' => 'Home Valuation Bot','slug' => 'valuation'],
            ['name' => 'Home Seller Bot', 'slug' => 'seller'],
        ];
        foreach($botTypes as &$type) { // Set Timestamp
            $type['created_at'] = Carbon::now();
            $type['updated_at'] = Carbon::now();
        }
        BotType::insert($botTypes);

        // Assign the "General Bot" to all the existings pages and lead fields.
        $generalBotType = BotType::where('slug', 'general')->first();
        LeadField::query()->withTrashed()->update([
            'bot_type_id' => $generalBotType->id,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Page::query()->withTrashed()->update(['bot_type_id' => null]);
        LeadField::query()->withTrashed()->update(['bot_type_id' => null]);

        BotType::whereIn('slug', ['general', 'listing', 'valuation', 'seller'])->delete();
    }
}
