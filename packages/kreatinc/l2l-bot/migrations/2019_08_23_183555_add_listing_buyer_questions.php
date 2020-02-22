<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

use Kreatinc\Bot\Models\BotType;
use Kreatinc\Bot\Models\LeadField;

class AddListingBuyerQuestions extends Migration
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
            // Prequalified
            [
                'field' => [
                    'type'        => 'buyer',
                    'title'       => 'Prequalified',
                    'entity_key'  => 'prequalified',
                    'entity_type' => '',
                    'question'    => 'Are you prequalified yet?',
                    'position'    => 3
                ],
                'choices' => [
                    [
                        'type'    => 'text',
                        'text'    => 'Yes',
                        'payload' => 'yes',
                    ],
                    [
                        'type'    => 'text',
                        'text'    => 'No',
                        'payload' => 'no',
                    ],
                ]
            ],
            // Quote
            [
                'field' => [
                    'type'        => 'buyer',
                    'title'       => 'Quote',
                    'entity_key'  => 'quote',
                    'entity_type' => '',
                    'question'    => 'Great! That will help you in your home buying process a lot!|Do you think getting another quote to make sure you have the lowest rate and best terms would be helpful?',
                    'position'    => 4
                ],
                'choices' => [
                    [
                        'type'    => 'text',
                        'text'    => 'Yes',
                        'payload' => 'yes',
                    ],
                    [
                        'type'    => 'text',
                        'text'    => 'No',
                        'payload' => 'no',
                    ],
                ]
            ],
            // Prequalified Ready
            [
                'field' => [
                    'type'        => 'buyer',
                    'title'       => 'Prequalified Ready',
                    'entity_key'  => 'prequalified_ready',
                    'entity_type' => '',
                    'question'    => 'Ok. That sounds great!|Can I help you get prequalified so that when you find a house you love, that you are able to write an offer?… It is free and there is no obligation of course. It just gets you ready is all.',
                    'position'    => 5
                ],
                'choices' => [
                    [
                        'type'    => 'text',
                        'text'    => 'Yes',
                        'payload' => 'yes',
                    ],
                    [
                        'type'    => 'text',
                        'text'    => 'No',
                        'payload' => 'no',
                    ],
                ]
            ],
            // Visit Home
            [
                'field' => [
                    'type'        => 'buyer',
                    'title'       => 'Visit Home',
                    'entity_key'  => 'visit_home',
                    'entity_type' => '',
                    'question'    => 'Would you like see this home?',
                    'position'    => 6
                ],
                'choices' => [
                    [
                        'type'    => 'text',
                        'text'    => 'Yes',
                        'payload' => 'yes',
                    ],
                    [
                        'type'    => 'text',
                        'text'    => 'No',
                        'payload' => 'no',
                    ],
                ]
            ],
            // Visit Home Time
            [
                'field' => [
                    'type'        => 'buyer',
                    'title'       => 'Visit Home Time',
                    'entity_key'  => 'visit_home_time',
                    'entity_type' => 'datetime',
                    'question'    => 'Please let me know what day works best for you and I will confirm back with you ASAP.',
                    'position'    => 7
                ],
                'choices' => [
                    [
                        'type'    => 'text',
                        'text'    => 'Tomorrow',
                        'payload' => 'Tomorrow',
                    ],
                    [
                        'type'    => 'text',
                        'text'    => 'This weekend',
                        'payload' => 'This weekend',
                    ],
                    [
                        'type'    => 'text',
                        'text'    => 'Next Week',
                        'payload' => 'Next Week',
                    ],
                ]
            ],
        ];
    }
}

