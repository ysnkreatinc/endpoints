<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSentencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function() {
            Schema::create('sentences', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('lead_field_id')->unsigned();
                $table->string('sentence_type');
                $table->text('text');

                $table->foreign('lead_field_id')->references('id')->on('lead_fields');

                $table->timestamps();
            });

            // Fill this table with existing questions
            $now = now()->toDateTimeString();
            $rows = DB::table('lead_fields')->whereNull('deleted_at')->get(['id', 'question']);
            $questions = [];
            foreach ($rows as $r) {
                $questions[] = [
                    'lead_field_id' => $r->id,
                    'text' => $r->question,
                    'sentence_type' => 'question',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('sentences')->insert($questions);

            Schema::table('lead_fields', function (Blueprint $table) {
                $table->dropColumn(['question']);
            });
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
