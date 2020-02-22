<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

use Kreatinc\Bot\Models\BotType;
use Kreatinc\Bot\Models\LeadField;

class AddHomeValuationQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Change phone and schedule order and data.
        foreach (['general', 'valuation'] as $type) {
            $botType = BotType::where('slug', $type)->first();

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

            $botType->fields()->where('entity_key', 'phone')->update([
                'position' => 8,
                'question' => 'As we have a wide range for the value estimate of your home|And that every home is unique|Let\'s chat about your home’s actual value.|Is this the best way to get a hold of you :email: or would you prefer a quick phone call or text?',
            ]);
            $botType->fields()->where('entity_key', 'schedule')->update([
                'position' => 9,
                'question' => 'Great! I will get back with you shortly!|You know, if you are thinking about selling in the next year,|would you like to set a tentative time for a detailed home value, as in, what would it list for now?',
            ]);
            $botType->fields()->where('entity_key', 'visit_date')->update([
                'position' => 10,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach(['general', 'valuation'] as $type) {
            $botType = BotType::where('slug', $type)->first();

            foreach ($this->getFields() as $item) {
                LeadField::where([
                    'type'        => $item['field']['type'],
                    'bot_type_id' => $botType->id,
                    'entity_key'  => $item['field']['entity_key'],
                ])->delete();
            }

            $botType->fields()->where('entity_key', 'phone')->update([
                'position' => 4,
                'question' => 'We are almost done! 👍|What’s your phone number? ☎️',
            ]);
            $botType->fields()->where('entity_key', 'schedule')->update([
                'position' => 5,
                'question' => 'As you can see, online value estimates can have from a little to a lot of variances.|If you are thinking about selling in the next year, I can get you a much more precise home value.|You will be able to add valuable information regarding upgrades, unique features of your home and more for a more precise value estimate!|If you would like to set a tentative time now, please click below:',
            ]);
            $botType->fields()->where('entity_key', 'visit_date')->update([
                'position' => 6,
            ]);
        }
    }

    public function getFields()
    {
        return [
            // Home Updates
            [
                'field' => [
                    'type'        => 'valuation',
                    'title'       => 'Home Update',
                    'entity_key'  => 'home_updates',
                    'entity_type' => '',
                    'question'    => 'Have you done any updates or work on your home?',
                    'position'    => 4
                ],
                'choices' => [
                    ['type' => 'text', 'text' => 'Yes', 'payload' => 'yes'],
                    ['type' => 'text', 'text' => 'No', 'payload' => 'no'],
                ]
            ],
            // Home Updates Data
            [
                'field' => [
                    'type'        => 'valuation',
                    'title'       => 'Home Updates Data',
                    'entity_key'  => 'home_updates_data',
                    'entity_type' => '',
                    'question'    => 'Please let me know what work you did!',
                    'position'    => 5
                ],
            ],
            // More Valuable
            [
                'field' => [
                    'type'        => 'valuation',
                    'title'       => 'More Valuable',
                    'entity_key'  => 'more_valuable',
                    'entity_type' => '',
                    'question'    => 'Is there anything else that you feel makes your home more valuable than others around you?',
                    'position'    => 6
                ],
                'choices' => [
                    ['type' => 'text', 'text' => 'Yes', 'payload' => 'yes'],
                    ['type' => 'text', 'text' => 'No', 'payload' => 'no'],
                ]
            ],
            // More Valuable Data
            [
                'field' => [
                    'type'        => 'valuation',
                    'title'       => 'More Valuable Data',
                    'entity_key'  => 'more_valuable_data',
                    'entity_type' => '',
                    'question'    => 'Great! Please let me know what it is! 😀',
                    'position'    => 7
                ],
            ],

        ];
    }
}

