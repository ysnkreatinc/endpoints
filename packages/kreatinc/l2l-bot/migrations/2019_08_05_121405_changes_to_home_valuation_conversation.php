<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kreatinc\Bot\Models\LeadField;

class ChangesToHomeValuationConversation extends Migration
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
            'entity_key' => 'street',
        ])->update([
            'question'    => 'Please type in the street address only (Do not include the city or state).|eg. ✅ 123 Main Street|❌ 123 Main Street, New York, NY',
        ]);
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
            'question'    => 'Please type in the street address only (Do not include the city or state).|eg. ✅ 523 Margaret Ct|❌ 523 Margaret Ct, Layton, Utah',
        ]);
    }
}
