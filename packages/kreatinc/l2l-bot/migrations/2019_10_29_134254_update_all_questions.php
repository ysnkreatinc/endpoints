<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAllQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function() {
            $now = now()->toDateTimeString();
            DB::table('conversations')
                ->whereNull('closed_at')
                ->update(['closed_at' => $now]);

            DB::table('field_choices')->truncate();
            DB::table('sentences')->truncate();
            DB::table('lead_fields')->delete();

            $intents = DB::table('intents')->pluck('id', 'slug')->all();

            foreach ($this->getAllFields() as $intent => $all_fields) {
                $position = 1;
                foreach ($all_fields as $item) {
                    $choices = $item['choices'] ?? [];
                    $field = $item['field'];
                    $field['type'] = $intent;
                    $field['intent_id'] = $intents[$intent];
                    $field['position'] = $position++;

                    $field_id = DB::table('lead_fields')->insertGetId($field);
                    foreach ($choices as &$choice) {
                        $choice['lead_field_id'] = $field_id;
                        $choice['type'] = $choice['type'] ?? 'text';
                        $choice['payload'] = $choice['payload'] ?? $choice['text'];
                    }
                    DB::table('field_choices')->insert($choices);
                    $questions = [];
                    $questions[] = [
                        'lead_field_id' => $field_id,
                        'text' => $item['question'],
                        'sentence_type' => 'question'
                    ];
                    if (isset($item['reply_after'])) {
                        $questions[] = [
                            'lead_field_id' => $field_id,
                            'text' => $item['reply_after'],
                            'sentence_type' => 'reply_after'
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
                    'field' => [
                        'title' => 'Price',
                        'entity_key' => 'price',
                        'entity_type' => 'amount_of_money'
                    ],
                    'question' => 'How much are you willing to spend on your new house? 💵',
                    'choices' => [
                        [
                            'text' => '$150k - $299k',
                            'payload' => '150000 - 299000',
                        ],
                        [
                            'text' => '$300k - $499k',
                            'payload' => '300000 - 499000',
                        ],
                        [
                            'text' => '$500k - $699k',
                            'payload' => '500000 - 699000',
                        ],
                        [
                            'text' => '$700+k',
                            'payload' => '700000 - 1000000',
                        ],
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Moving Date',
                        'entity_key' => 'date',
                        'entity_type' => 'datetime'
                    ],
                    'question' => 'Cool! 😎 How soon do you need to move?',
                    'choices' => [
                        [
                            'text' => 'ASAP',
                        ],
                        [
                            'text' => 'In 3 months',
                        ],
                        [
                            'text' => 'In 6 months',
                        ],
                        [
                            'text' => 'In a year',
                        ]
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Preferred City',
                        'entity_key' => 'address',
                        'entity_type' => 'location',
                        'validation' => 'address|city',
                    ],
                    'question' => 'What is your preferred city/neighborhood?'
                ],
                [
                    'field' => [
                        'title' => 'Another realtor',
                        'entity_key' => 'another_realtor',
                        'entity_type' => 'confirm'
                    ],
                    'question' => 'Awesome! Are you working with another realtor at the moment?',
                    'choices' => [
                        [
                            'text' => 'Yes',
                            'payload' => 'yes',
                        ],
                        [
                            'text' => 'No',
                            'payload' => 'no',
                        ],
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Pre-qualified',
                        'entity_key' => 'pre_qualified',
                        'entity_type' => 'confirm'
                    ],
                    'question' => 'Are you pre-qualified yet?',
                    'choices' => [
                        [
                            'text' => 'Yes',
                            'payload' => 'yes',
                        ],
                        [
                            'text' => 'No',
                            'payload' => 'no',
                        ],
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Email',
                        'entity_key' => 'email',
                        'entity_type' => ''
                    ],
                    'question' => 'Thanks for your responses, {{user_first_name}}. I\'ll send you a list of houses that fit your needs.|I just need your contact details to proceed.|What\'s your email address? ✉️',
                    'choices' => [
                        [
                            'type' => 'user_email',
                            'text' => '',
                        ]
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Phone number',
                        'entity_key' => 'phone',
                        'entity_type' => 'phone_number',
                        'actions' => 'buyer_suggestions'
                    ],
                    'question' => 'And your phone number? ☎️',
                    'reply_after' => 'Thanks again!',
                    'choices' => [
                        [
                            'type' => 'user_phone_number',
                            'text' => '',
                        ],
                        [
                            'text' => 'Skip',
                            'payload' => 'skip',
                        ],
                    ]
                ],
            ],
            'seller' => [
                [
                    'field' => [
                        'title' => 'Property to Sell',
                        'entity_key' => 'property',
                        'entity_type' => ''
                    ],
                    'question' => 'What are you selling? 🏡|(Scroll ➡️ to see more)',
                    'choices' => [
                        [
                            'text' => 'Single Family',
                        ],
                        [
                            'text' => 'Condo',
                        ],
                        [
                            'text' => 'Duplex',
                        ],
                        [
                            'text' => 'Commercial',
                        ],
                        [
                            'text' => 'Other',
                        ]
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Number of Bedrooms',
                        'entity_key' => 'bedrooms',
                        'entity_type' => 'number'
                    ],
                    'question' => 'Cool! 😎 How many bedrooms does it have?',
                    'choices' => [
                        [
                            'text' => '1',
                        ],
                        [
                            'text' => '2',
                        ],
                        [
                            'text' => '3',
                        ],
                        [
                            'text' => '4',
                        ],
                        [
                            'text' => '5 or more',
                        ],
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Number of Bathrooms',
                        'entity_key' => 'bathrooms',
                        'entity_type' => 'number',
                    ],
                    'question' => 'And how many bathrooms? 🛁',
                    'choices' => [
                        [
                            'text' => '1',
                        ],
                        [
                            'text' => '2',
                        ],
                        [
                            'text' => '3',
                        ],
                        [
                            'text' => '4 or more',
                        ],
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Selling Date',
                        'entity_key' => 'date',
                        'entity_type' => 'datetime'
                    ],
                    'question' => 'How soon do you need to sell?',
                    'choices' => [
                        [
                            'text' => 'Immediately',
                        ],
                        [
                            'text' => 'Within 3 months',
                        ],
                        [
                            'text' => 'Within 6 months',
                        ],
                        [
                            'text' => 'In no rush',
                        ],
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Importance',
                        'entity_key' => 'importance',
                        'entity_type' => '',
                        'validation' => 'any_text',
                        'store_raw_value' => true,
                    ],
                    'question' => 'What is most important to you in this sale?',
                    'choices' => [
                        [
                            'text' => 'Price',
                        ],
                        [
                            'text' => 'Speed',
                        ],
                        [
                            'text' => 'Ease of transaction',
                        ],
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Occupancy',
                        'entity_key' => 'occupancy',
                        'entity_type' => '',
                        'validation' => 'any_text',
                        'store_raw_value' => true,
                    ],
                    'question' => 'What is the current occupancy status of the property? 🏡',
                    'choices' => [
                        [
                            'text' => 'It\'s vacant',
                        ],
                        [
                            'text' => 'It\'s rented out',
                        ],
                        [
                            'text' => 'I live here',
                        ],
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Price',
                        'entity_key' => 'price',
                        'entity_type' => 'amount_of_money'
                    ],
                    'question' => 'What do you think the property is worth today?'
                ],
                [
                    'field' => [
                        'title' => 'Email',
                        'entity_key' => 'email',
                        'entity_type' => ''
                    ],
                    'question' => 'Thanks for your responses, {{user_first_name}}. I\'ll contact you soon to continue assisting you in the selling process.|I just need your contact details to proceed.|What\'s your email address? ✉️',
                    'choices' => [
                        [
                            'type' => 'user_email',
                            'text' => '',
                        ]
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Phone number',
                        'entity_key' => 'phone',
                        'entity_type' => 'phone_number',
                    ],
                    'question' => 'And your phone number? ☎️',
                    'reply_after' => 'Thanks again! I will get in touch with you shortly! 👌',
                    'choices' => [
                        [
                            'type' => 'user_phone_number',
                            'text' => '',
                        ],
                        [
                            'text' => 'Skip',
                            'payload' => 'skip',
                        ],
                    ]
                ],
            ],
            'listing' => [
                [
                    'field' => [
                        'title' => 'Email',
                        'entity_key' => 'email',
                        'entity_type' => '',
                        'actions' => 'show_listing'
                    ],
                    'question' => 'Which email address can I use to notify you if the status of this property changes? ✉️',
                    'choices' => [
                        [
                            'type' => 'user_email',
                            'text' => '',
                        ]
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Pre-qualified',
                        'entity_key' => 'pre_qualified',
                        'entity_type' => 'confirm'
                    ],
                    'question' => 'Quick question.|Are you pre-qualified yet?',
                    'choices' => [
                        [
                            'text' => 'Yes',
                            'payload' => 'yes',
                        ],
                        [
                            'text' => 'No',
                            'payload' => 'no',
                        ],
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Schedule',
                        'entity_key' => 'schedule',
                        'entity_type' => 'confirm'
                    ],
                    'question' => 'Last question, would you like to schedule a showing to see this property?',
                    'choices' => [
                        [
                            'text' => 'Yes, that would be nice',
                            'payload' => 'yes',
                        ],
                        [
                            'text' => 'No, thanks',
                            'payload' => 'no',
                        ],
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Schedule Date',
                        'entity_key' => 'schedule_date',
                        'entity_type' => 'date',
                        'is_hidden' => true,
                    ],
                    'question' => 'Awesome! Please let me know what date works best for you and I will confirm back with you ASAP.|(Select one of the options below or type a date)',
                    'reply_after' => 'Okay, I will contact you soon',
                    'choices' => [
                        [
                            'text' => 'Tomorrow',
                        ],
                        [
                            'text' => 'This weekend',
                        ],
                        [
                            'text' => 'Next week',
                        ],
                    ]
                ],
            ],
            'valuation' => [
                [
                    'field' => [
                        'title' => 'Street',
                        'entity_key' => 'street',
                        'entity_type' => '',
                        'validation' => 'street',
                        'store_raw_value' => true,
                    ],
                    'question' => '{{user_first_name}}, please type in the street address only. (Do not include the city or state.)|Eg. ✅ 123 Main Street|🚫 123 Main Street, New York, NY',
                ],
                [
                    'field' => [
                        'title' => 'Zip code',
                        'entity_key' => 'zipcode',
                        'entity_type' => 'number',
                        'validation' => 'zipcode',
                    ],
                    'question' => 'Great. Now just type in the {{zipcode}}.',
                ],
                [
                    'field' => [
                        'title' => 'Email',
                        'entity_key' => 'email',
                        'entity_type' => '',
                        'actions' => 'home_valuation',
                    ],
                    'question' => 'Just a few 🕐 seconds, I\'m looking for it now.|Which email address can I use to notify you if the value of your home changes in the near future?',
                    'choices' => [
                        [
                            'type' => 'user_email',
                            'text' => '',
                        ]
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Contact Me',
                        'entity_key' => 'contact_me',
                        'entity_type' => 'confirm',
                        'validation' => 'contact_me',
                        'is_hidden' => true,
                        'store_raw_value' => true,
                    ],
                    'question' => 'Please note that this is just an automated estimate of your property\'s value. I know I can do better than this!|Would you like me to email or call you to chat more about how much you could sell your house for?',
                    'choices' => [
                        [
                            'text' => 'Email me',
                            'payload' => 'email',
                        ],
                        [
                            'text' => 'Call me',
                            'payload' => 'call',
                        ],
                        [
                            'text' => 'No, thank you',
                            'payload' => 'no',
                        ],
                    ]
                ],
                [
                    'field' => [
                        'title' => 'Phone number',
                        'entity_key' => 'phone',
                        'entity_type' => 'phone_number',
                        'is_hidden' => true,
                    ],
                    'question' => 'Sounds good. Could you please provide me your phone number?',
                    'reply_after' => 'Thank you. I will contact you soon!',
                    'choices' => [
                        [
                            'type' => 'user_phone_number',
                            'text' => '',
                        ],
                    ]
                ],
            ],
        ];
    }
}
