<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

use Kreatinc\Bot\Models\BotType;
use Kreatinc\Bot\Models\LeadField;

class AddNewQuestionToListingBot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $botType = BotType::where('slug', 'listing')->first();

        foreach ($this->getFields() as &$item) {
            $choices = $item['choices'] ?? [];

            $field = $item['field'];
            $field['created_at'] = Carbon::now();
            $field['updated_at'] = Carbon::now();
            $field['bot_type_id'] = $botType->id;

            $field_id = \DB::table('lead_fields')->insertGetId($field);
            foreach ($choices as &$choice) {
                $choice['lead_field_id'] = $field_id;
                \DB::table('field_choices')->insert($choice);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $botType = BotType::where('slug', 'listing')->first();

        foreach ($this->getFields() as $item) {
            LeadField::where([
                'type'        => $item['field']['type'],
                'bot_type_id' => $botType->id,
                'entity_key'  => $item['field']['entity_key'],
            ])->delete();
        }
    }

    public function getFields()
    {
        return [
            // Email|Phone
            [
                'field' => [
                    'type'        => 'buyer',
                    'title'       => 'Email or phone',
                    'entity_key'  => 'email_phone',
                    'entity_type' => '',
                    'question'    => 'Great! Let me check and get back with you ASAP. Should I email or text you to confirm?',
                    'position'    => 8
                ],
                'choices' => [
                    ['type' => 'user_phone_number', 'text' => '', 'payload' => ''],
                    ['type' => 'user_email', 'text' => '', 'payload' => '']
                ]
            ],
        ];
    }
}

