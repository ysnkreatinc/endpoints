<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Date;

class AddSoftDeleteLeadFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_fields', function (Blueprint $table) {
            $table->softDeletes();
        });

        \DB::table('lead_fields')
            ->where(function($q) {
                $q->where('type', 'valuation')
                  ->where('entity_key', 'address');
            })
            ->orWhere(function($q) {
                $q->where('type', 'buyer')
                  ->where('entity_key', 'bedrooms');
            })
            ->orWhere(function($q) {
                $q->where('type', 'buyer')
                  ->where('entity_key', 'bathrooms');
            })
            ->update(['deleted_at' => Date::now()]);
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
