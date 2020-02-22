<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Date;
use Kreatinc\Bot\Models\LeadField;

class UpdateHomeValueMsg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('lead_fields')
            ->where(function($q) {
                $q->where('type', 'valuation')
                  ->where('entity_key', 'phone');
            })
            ->orWhere(function($q) {
                $q->where('type', 'valuation')
                  ->where('entity_key', 'email');
            })
            ->update(['deleted_at' => Date::now()]);

        $l = LeadField::where('entity_key', 'visit_date')->first();
        $l->question = $l->question .'|Eg. Tomorrow, Next Tuesday, or June 5, 2019';
        $l->save();
        $l->fieldChoices()->create([
                        'type' => 'text',
                        'text' => 'Sometime this month',
                        'payload' => 'Sometime this month',
                    ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('lead_fields')
            ->where(function($q) {
                $q->where('type', 'valuation')
                  ->where('entity_key', 'phone');
            })
            ->orWhere(function($q) {
                $q->where('type', 'valuation')
                  ->where('entity_key', 'email');
            })
            ->update(['deleted_at' => null]);
        $l = LeadField::where('entity_key', 'visit_date')->first();
        $l->question = 'What is the best time to contact you to schedule a showing?';
        $l->save();
        $l->fieldChoices()->where('text', 'Sometime this month')->delete();
    }

}
