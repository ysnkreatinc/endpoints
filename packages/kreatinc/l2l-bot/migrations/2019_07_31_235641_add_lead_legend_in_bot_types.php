<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kreatinc\Bot\Models\BotType;

class AddLeadLegendInBotTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bot_types', function (Blueprint $table) {
            $table->string('lead_legend')->nullable()->after('slug');
        });

        // Replace Bot to BOT.
        foreach(BotType::all() as $type) {
            $type->update([
                'name' => str_replace('Bot', 'BOT', $type->name),
            ]);
        }

        // Set default "lead_legend" values.
        BotType::where('slug', 'general')->update(['lead_legend' => 'BOT-G']);
        BotType::where('slug', 'listing')->update(['lead_legend' => 'BOT-L']);
        BotType::where('slug', 'valuation')->update(['lead_legend' => 'BOT-HV']);
        BotType::where('slug', 'seller')->update(['lead_legend' => 'BOT-HS']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bot_types', function (Blueprint $table) {
            $table->dropColumn('lead_legend');

            // Replace Bot to BOT.
            foreach(BotType::all() as $type) {
                $type->update([
                    'name' => str_replace('BOT', 'Bot', $type->name),
                ]);
            }
        });
    }
}
