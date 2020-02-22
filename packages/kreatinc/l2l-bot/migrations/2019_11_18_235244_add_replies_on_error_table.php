<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRepliesOnErrorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function() {
            DB::table('field_choices')
                ->where('text', 'Yes, that would be nice')
                ->update(['text' => 'Yes, please!']);

            DB::table('intents')
                ->where('slug', 'listing')
                ->update(['label' => 'Get Listing Info']);

            foreach ($this->getAllFields() as $intent => $all_fields) {
                foreach ($all_fields as $field) {
                    $f = DB::table('lead_fields')
                        ->where('type', $intent)
                        ->where('entity_key', $field['entity_key'])
                        ->first();

                    $questions = [];
                    $questions[] = [
                        'lead_field_id' => $f->id,
                        'text' => $field['error_level_1'],
                        'sentence_type' => 'error_level_1'
                    ];
                    if (isset($field['error_level_2'])) {
                        $questions[] = [
                            'lead_field_id' => $f->id,
                            'text' => $field['error_level_2'],
                            'sentence_type' => 'error_level_2'
                        ];
                    }
                    DB::table('sentences')->insert($questions);
                }
            }
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

    public function getAllFields()
    {
        return [
            'buyer' => [
                [
                    'entity_key' => 'price',
                    'error_level_1' => 'How much are you willing to spend on your new house? 💵|Please select one of the options below or enter a $ amount instead. 
For example, $150k or 1 million.',
                ],
                [
                    'entity_key' => 'date',
                    'error_level_1' => 'How soon do you need to move?|Please select one of the options below or enter something like "In two weeks", "In 3 months" etc..',
                ],
                [
                    'entity_key' => 'address',
                    'error_level_1' => 'Please enter a valid city, state or neighborhood. For example, “Los Angeles” “Toronto” or "Granite Bay, California".'
                ],
                [
                    'entity_key' => 'another_realtor',
                    'error_level_1' => 'Are you working with another realtor at the moment?|Please select one of the options below.',
                ],
                [
                    'entity_key' => 'pre_qualified',
                    'error_level_1' => 'Are you pre-qualified yet?|Please select one of the options below.',
                ],
                [
                    'entity_key' => 'email',
                    'error_level_1' => 'Please type in a valid email address?',
                ],
                [
                    'entity_key' => 'phone',
                    'error_level_1' => 'Please type in a valid phone number?',
                ],
            ],
            'seller' => [
                [
                    'entity_key' => 'property',
                    'error_level_1' => 'What are you selling?|For example, Single Family or Duplex.',
                ],
                [
                    'entity_key' => 'bedrooms',
                    'error_level_1' => 'How many bedrooms does it have?|For example, 3 Bathrooms or two baths.',
                ],
                [
                    'entity_key' => 'bathrooms',
                    'error_level_1' => 'How many bathrooms does it have?|For example, 3 Bathrooms or two baths.',
                ],
                [
                    'entity_key' => 'date',
                    'error_level_1' => 'Please select one of the options below or enter something like "In two weeks", "In 3 months" etc..',
                ],
                [
                    'entity_key' => 'importance',
                    'error_level_1' => 'What\'s most important to you in this sale?|Please select one of the options below.',
                ],
                [
                    'entity_key' => 'occupancy',
                    'error_level_1' => 'What is the current occupancy status of the property?|Please select one of the options below.',
                ],
                [
                    'entity_key' => 'price',
                    'error_level_1' => 'What do you think the property is worth today?|For example, $150k or 1 million.'
                ],
                [
                    'entity_key' => 'email',
                    'error_level_1' => 'Please type in a valid email address?',
                ],
                [
                    'entity_key' => 'phone',
                    'error_level_1' => 'Please type in a valid phone number?',
                ],
            ],
            'listing' => [
                [
                    'entity_key' => 'email',
                    'error_level_1' => 'Please type in a valid email address?',
                ],
                [
                    'entity_key' => 'pre_qualified',
                    'error_level_1' => 'Are you pre-qualified yet?|Please select one of the options below.',
                ],
                [
                    'entity_key' => 'schedule',
                    'error_level_1' => 'Would you like to schedule a showing to see this property?|Please select one of the options below.',
                ],
                [
                    'entity_key' => 'schedule_date',
                    'error_level_1' => 'Please let me know what date works best for you?|Please select one of the options below or type a date.',
                ],
            ],
            'valuation' => [
                [
                    'entity_key' => 'street',
                    'error_level_1' => 'Please type in the street address only. (Do not include the city or state.)|Eg. ✅ 123 Main Street|🚫 123 Main Street, New York, NY',
                ],
                [
                    'entity_key' => 'zipcode',
                    'error_level_1' => 'Please type in a valid {{zipcode}}?',
                ],
                [
                    'entity_key' => 'email',
                    'error_level_1' => 'Please type in a valid email address?',
                ],
                [
                    'entity_key' => 'contact_me',
                    'error_level_1' => 'Would you like me to email or call you to chat more about how much you could sell your house for?|Please select one of the options below.',
                ],
                [
                    'entity_key' => 'phone',
                    'error_level_1' => 'Please type in a valid phone number?',
                ],
            ],
        ];
    }
}
