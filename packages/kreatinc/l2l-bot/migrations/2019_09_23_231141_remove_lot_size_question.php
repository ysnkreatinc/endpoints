<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//Model
use Kreatinc\Bot\Models\LeadField;

class RemoveLotSizeQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          LeadField::where('type', 'seller')
                   ->where('entity_key', 'size')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          LeadField::onlyTrashed()->where('type', 'seller')
                                  ->where('entity_key', 'size')->restore();
    }
}
