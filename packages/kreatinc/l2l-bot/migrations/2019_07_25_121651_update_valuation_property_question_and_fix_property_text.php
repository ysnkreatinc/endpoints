<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kreatinc\Bot\Models\LeadField;

class UpdateValuationPropertyQuestionAndFixPropertyText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        LeadField::where([
            'type' => 'valuation',
            'entity_key' => 'address'
        ])->update(['question' => 'What is your property address?|Eg. 123 Main Street, New York, NY|Eg. 123 Main Street, 95630']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        LeadField::where([
            'type' => 'valuation',
            'entity_key' => 'address'
        ])->update(['question' => 'Great! What is your property address?|Eg. 123 Main Street, New York, NY']);
    }
}
