<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FillDefaultHomeValueQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('ALTER TABLE lead_fields MODIFY COLUMN question VARCHAR(600);');

        $position = 1;
        foreach ($this->getValuationFields() as $item) {
            $choices = $item['choices'] ?? [];
            $field = $item['field'];
            $field['type'] = 'valuation';
            $field['position'] = $position++;

            $field_id = \DB::table('lead_fields')->insertGetId($field);
            foreach ($choices as $choice) {
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
        // 
    }

    public function getValuationFields()
    {
        return [
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
                    'type' => 'valuation',
                    'title' => 'Home Address',
                    'entity_key' => 'address',
                    'entity_type' => 'location',
                    'question' => "What's your property address?\neg. 123 Main Street, New York, NY",
                ]
            ],
            [
                'field' => [
                    'title' => 'Schedule',
                    'entity_key' => 'schedule',
                    'entity_type' => 'date',
                    'question' => 'As you can see, online value estimates can have from a little to a lot of variances.|When would be the best time for a free in-home valuation?|You will be able to add valuable information regarding upgrades, unique features of your home and more for a more precise value estimate!|If you would like to set a tentative time now, please click below:'
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
                    'question' => 'What is the best time to contact you to schedule a showing?'
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
                    ]
                ]
            ],
        ];
    }

}
