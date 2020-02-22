<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// Models
use Kreatinc\Bot\Models\LeadField;

class ResetEmailAndPhoneForValuationInLeadFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_fields', function (Blueprint $table) {
            // Restore "email" field.
            LeadField::onlyTrashed()->where([
                'type' => 'valuation',
                'entity_key' => 'email',
            ])->restore();
            // Restore "phone" field.
            LeadField::onlyTrashed()->where([
                'type' => 'valuation',
                'entity_key' => 'phone',
            ])->restore();

            // Update fields position.
            LeadField::where(['type' => 'valuation', 'entity_key' => 'address'])->update([ 'position' => 1 ]);
            LeadField::where(['type' => 'valuation', 'entity_key' => 'email'])->update([ 'position' => 2 ]);
            LeadField::where(['type' => 'valuation', 'entity_key' => 'phone'])->update([ 'position' => 3 ]);
            LeadField::where(['type' => 'valuation', 'entity_key' => 'schedule'])->update([ 'position' => 4 ]);
            LeadField::where(['type' => 'valuation', 'entity_key' => 'visit_date'])->update([ 'position' => 5 ]);
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
            // Restore fields position
            LeadField::where(['type' => 'valuation', 'entity_key' => 'address'])->update([ 'position' => 3 ]);
            LeadField::where(['type' => 'valuation', 'entity_key' => 'email'])->update([ 'position' => 2 ]);
            LeadField::where(['type' => 'valuation', 'entity_key' => 'phone'])->update([ 'position' => 1 ]);

            // Delete "email" field.
            LeadField::where([
                'type' => 'valuation',
                'entity_key' => 'email',
            ])->delete();

            // Delete "phone" field.
            LeadField::where([
                'type' => 'valuation',
                'entity_key' => 'phone',
            ])->delete();
        });
    }
}
