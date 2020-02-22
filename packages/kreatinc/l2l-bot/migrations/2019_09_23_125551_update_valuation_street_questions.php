<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Kreatinc\Bot\Models\LeadField;

class UpdateValuationStreetQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        LeadField::where('type', 'valuation')
            ->where('entity_key', 'street')
            ->update([
                'question' => 'Please type in the street address only (Do not include the city or state).|Eg. ✅ 123 Main Street|❌ 123 Main Street, New York, NY',
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
