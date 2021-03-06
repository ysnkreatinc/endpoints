<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// Models
use Kreatinc\Bot\Models\LeadField;

class UpdateBuyerAddressQuestionInLeadFields extends Migration
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
                'type' => 'buyer',
                'entity_key' => 'address'
            ])->update([
                'title' => 'Preferred City/Neighborhoods',
                'question' => 'What city or neighborhoods do you prefer?',
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
                'type' => 'buyer',
                'entity_key' => 'address'
            ])->update([
                'title' => 'Preferred City/Address',
                'question' => 'What is your preferred city/address?',
            ]);
        });
    }
}
