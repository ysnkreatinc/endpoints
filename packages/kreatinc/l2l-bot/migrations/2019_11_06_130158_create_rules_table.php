<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;

class CreateRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function() {
            Schema::table('lead_data', function (Blueprint $table) {
                $table->unsignedInteger('lead_field_id')->nullable()->change();
                $table->string('key')->nullable();
            });

            Schema::create('rules', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('lead_field_id')->unsigned();
                $table->string('rule_type'); // visibility, reply
                $table->string('target');    // entity_key
                $table->string('validation_rules');
                $table->text('success_reply')->nullable();
                $table->text('fail_reply')->nullable();

                $table->foreign('lead_field_id')->references('id')->on('lead_fields')->onDelete('cascade');

                $table->timestamps();
            });

            $intents = DB::table('intents')->pluck('id', 'slug')->all();
            $rules = [];

            $rules[] = $this->getRuleRow('schedule_date', $intents['listing'], [
                'type' => 'visibility',
                'target' => 'schedule',
                'validation' => 'agreed',
            ]);
            $rules[] = $this->getRuleRow('schedule', $intents['listing'], [
                'type' => 'reply',
                'target' => 'schedule',
                'validation' => 'refuse',
                'success' => 'No problem!',
            ]);
            $rules[] = $this->getRuleRow('phone', $intents['buyer'], [
                'type' => 'reply',
                'target' => 'buyer_suggestions',
                'validation' => 'empty',
                'success' => 'I will send you a list of houses in your preferred neighborhood shortly.',
            ]);
            $rules[] = $this->getRuleRow('email', $intents['valuation'], [
                'type' => 'reply',
                'target' => 'home_valuation',
                'validation' => 'empty',
                'success' => 'I am sorry, but this address is not in our system! We have most homes in the area, so I am sorry that yours is not available! 😞|I will have a Home Value Estimate prepared for you ASAP and send it to you via email! 😄🙏',
            ]);
            $rules[] = $this->getRuleRow('contact_me', $intents['valuation'], [
                'type' => 'visibility',
                'target' => 'home_valuation',
                'validation' => 'any_text'
            ]);
            $rules[] = $this->getRuleRow('phone', $intents['valuation'], [
                'type' => 'visibility',
                'target' => 'contact_me',
                'validation' => 'callme'
            ]);
            $rules[] = $this->getRuleRow('contact_me', $intents['valuation'], [
                'type' => 'reply',
                'target' => 'contact_me',
                'validation' => 'emailme',
                'success' => 'Sounds great. I will contact you soon!',
            ]);
            $rules[] = $this->getRuleRow('contact_me', $intents['valuation'], [
                'type' => 'reply',
                'target' => 'contact_me',
                'validation' => 'refuse',
                'success' => 'No problem!',
            ]);

            DB::table('rules')->insert($rules);
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

    public function getRuleRow($key, $intent_id, $data)
    {
        $field = DB::table('lead_fields')
            ->where('intent_id', $intent_id)
            ->where('entity_key', $key)
            ->first(['id']);
        $now = now()->toDateTimeString();
        return [
            'lead_field_id' => $field->id,
            'rule_type' => Arr::get($data, 'type'),
            'target' => Arr::get($data, 'target'),
            'validation_rules' => Arr::get($data, 'validation'),
            'success_reply' => Arr::get($data, 'success'),
            'fail_reply' => Arr::get($data, 'fail'),
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
}
