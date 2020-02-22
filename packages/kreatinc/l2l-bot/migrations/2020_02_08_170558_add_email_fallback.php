<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;

class AddEmailFallback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function() {
            $intent = DB::table('intents')->where('slug', 'valuation')->first();
            $l = DB::table('lead_fields')
                ->where('type', 'valuation')
                ->where('entity_key', 'phone')
                ->first();

            $field_id = DB::table('lead_fields')->insertGetId([
                'title' => 'Email Again',
                'entity_key' => 'email_again',
                'entity_type' => 'email',
                'type' => 'valuation',
                'intent_id' => $intent->id,
                'position' => ($l->position ?? 5) + 1,
                'is_hidden' => true,
            ]);
            DB::table('field_choices')->insert([
                'type' => 'user_email',
                'text' => '',
                'lead_field_id' => $field_id,
                'payload' => '',
            ]);

            DB::table('sentences')->insert([
                'lead_field_id' => $field_id,
                'text' => 'Which email address can I use to notify you?',
                'sentence_type' => 'question'
            ]);

            $now = now()->toDateTimeString();
            DB::table('rules')->insert([
                'lead_field_id' => $field_id,
                'rule_type' => 'visibility',
                'target'    => 'email',
                'validation_rules' => 'not_email',
                'created_at' => $now,
                'updated_at' => $now,
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
        // 
    }

}
