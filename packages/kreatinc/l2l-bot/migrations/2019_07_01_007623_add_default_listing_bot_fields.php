<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
use Kreatinc\Bot\Models\BotType;
use Kreatinc\Bot\Models\LeadField;

class AddDefaultListingBotFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $listingBot = BotType::where('slug', 'listing')->first();

        $position = 1;
        foreach ($this->getListingFields() as &$item) {
            $choices = $item['choices'] ?? [];
            $field = $item['field'];
            $field['type'] = 'buyer';
            $field['position'] = $position++;
            $field['created_at'] = Carbon::now();
            $field['updated_at'] = Carbon::now();
            $field['bot_type_id'] = $listingBot->id;

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
        $listingType = BotType::where('slug', 'listing')->first();
        LeadField::where('bot_type_id', $listingType->id)->delete();
    }

    public function getListingFields()
    {
        return [
            [
                'field' => [
                    'title' => 'Email',
                    'entity_key' => 'email',
                    'entity_type' => '',
                    'question' => 'Which email address shall we use to notify you?'
                ],
                'choices' => [
                    [
                        'type' => 'user_email',
                        'text' => '',
                        'payload' => '',
                    ]
                ]
            ],
            [
                'field' => [
                    'title' => 'Phone number',
                    'entity_key' => 'phone',
                    'entity_type' => 'phone_number',
                    'question' => 'We are almost done! 👍|What’s your phone number? ☎️'
                ],
                'choices' => [
                    [
                        'type' => 'user_phone_number',
                        'text' => '',
                        'payload' => '',
                    ]
                ]
            ],
        ];
    }
}
