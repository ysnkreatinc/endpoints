<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// Models
use Kreatinc\Bot\Models\LeadField;

class UpdateScheduleQuestionInLeadFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_fields', function (Blueprint $table) {
            LeadField::where([
                'type' => 'valuation',
                'entity_key' => 'schedule',
            ])->update([
                'question' => 'As you can see, online value estimates can have from a little to a lot of variances.|If you are thinking about selling in the next year, I can get you a much more precise home value.|You will be able to add valuable information regarding upgrades, unique features of your home and more for a more precise value estimate!|If you would like to set a tentative time now, please click below:',
            ]);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lead_fields', function (Blueprint $table) {
            LeadField::where([
                'type' => 'valuation',
                'entity_key' => 'schedule',
            ])->update([
                'question' => 'As you can see, online value estimates can have from a little to a lot of variances.|When would be the best time for a free in-home valuation?|You will be able to add valuable information regarding upgrades, unique features of your home and more for a more precise value estimate!|If you would like to set a tentative time now, please click below:',
            ]);
        });
    }
}
