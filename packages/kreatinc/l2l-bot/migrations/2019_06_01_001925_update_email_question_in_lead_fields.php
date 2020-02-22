<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// Models
use Kreatinc\Bot\Models\LeadField;

class UpdateEmailQuestionInLeadFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_fields', function (Blueprint $table) {
            LeadField::where('entity_key', 'email')->update([
                'question' => 'What\'s your preferred email?',
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
            // Buyer
            LeadField::where([
                'type' => 'buyer',
                'entity_key' => 'email',
            ])->update([
                'question' => 'What is your best email?',
            ]);

            // Seller
            LeadField::where([
                'type' => 'seller',
                'entity_key' => 'email',
            ])->update([
                'question' => 'What is your professionel email?',
            ]);
        });
    }
}
