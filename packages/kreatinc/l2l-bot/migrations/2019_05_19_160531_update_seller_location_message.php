<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


// Models
use Kreatinc\Bot\Models\LeadField;

class UpdateSellerLocationMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $field = LeadField::where([
            'type'       => 'seller',
            'entity_key' => 'address'
        ])->first();

        // Update.
        $field->update([
            'question'    => 'What is your property address?|eg. 123 Main Street, New York, NY',
        ]);

        // Remove choices.
        $field->fieldChoices()->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $field = LeadField::where([
            'type'       => 'seller',
            'entity_key' => 'address'
        ])->first();

        // Update.
        $field->update([
            'question'    => 'What is your property address?',
        ]);

        // Create choices.
        $field->fieldChoices()->create([
            'type'    => 'location',
            'text'    => '',
            'payload' => '',
        ]);
    }
}
