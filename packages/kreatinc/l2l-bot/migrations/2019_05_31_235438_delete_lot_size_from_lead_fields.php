<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// Models
use Kreatinc\Bot\Models\LeadField;

class DeleteLotSizeFromLeadFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_fields', function (Blueprint $table) {
            LeadField::where('entity_key', 'size')->delete();
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
            LeadField::onlyTrashed()->where('entity_key', 'size')->restore();
        });
    }
}
