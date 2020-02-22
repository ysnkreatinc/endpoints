<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
use Kreatinc\Bot\Models\BotType;
use Kreatinc\Bot\Models\LeadField;

class AddDefaultValuationBotFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $valuationBot = BotType::where('slug', 'valuation')->first();

        $position = 1;
        foreach ($this->getValuationFields() as &$item) {
            $choices = $item['choices'] ?? [];
            $field = $item['field'];
            $field['type'] = 'valuation';
            $field['position'] = $position++;
            $field['created_at'] = Carbon::now();
            $field['updated_at'] = Carbon::now();
            $field['bot_type_id'] = $valuationBot->id;

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
        $valuationType = BotType::where('slug', 'valuation')->first();
        LeadField::where('bot_type_id', $valuationType->id)->delete();
    }

    public function getValuationFields()
    {
        return [
            [
                'field' => [
                    'type' => 'valuation',
                    'title' => 'Home Address',
                    'entity_key' => 'address',
                    'entity_type' => 'location',
                    'question' => "What's your property address? eg. 123 Main Street, New York, NY",
                ]
            ],
            [
                'field' => [
                    'title' => 'Email',
                    'entity_key' => 'email',
                    'entity_type' => '',
                    'question' => 'What is your preferred email?'
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
                    'question' => 'What is your phone number?'
                ],
                'choices' => [
                    [
                        'type' => 'user_phone_number',
                        'text' => '',
                        'payload' => '',
                    ]
                ]
            ],
            [
                'field' => [
                    'title' => 'Schedule',
                    'entity_key' => 'schedule',
                    'entity_type' => 'date',
                    'question' => 'As you can see, online value estimates can have from a little to a lot of variances.|If you are thinking about selling in the next year, I can get you a much more precise home value.|You will be able to add valuable information regarding upgrades, unique features of your home and more for a more precise value estimate!|If you would like to set a tentative time now, please click below:'
                ],
                'choices' => [
                    [
                        'type' => 'text',
                        'text' => 'Schedule Now',
                        'payload' => 'schedule',
                    ],
                    [
                        'type' => 'text',
                        'text' => 'Remind Me Later',
                        'payload' => 'remind_later',
                    ],
                    [
                        'type' => 'text',
                        'text' => 'No, Thank You',
                        'payload' => 'no',
                    ]
                ]
            ],
            [
                'field' => [
                    'title' => 'Visit Date',
                    'entity_key' => 'visit_date',
                    'entity_type' => 'datetime',
                    'question' => 'What is the best time to contact you to schedule a showing?|Eg. Tomorrow, Next Tuesday, or June 5, 2019'
                ],
                'choices' => [
                    [
                        'type' => 'text',
                        'text' => 'Tomorrow',
                        'payload' => 'Tomorrow',
                    ],
                    [
                        'type' => 'text',
                        'text' => 'This weekend',
                        'payload' => 'This weekend',
                    ],
                    [
                        'type' => 'text',
                        'text' => 'Sometime this month',
                        'payload' => 'Sometime this month',
                    ],
                ]
            ],
        ];
    }
}
