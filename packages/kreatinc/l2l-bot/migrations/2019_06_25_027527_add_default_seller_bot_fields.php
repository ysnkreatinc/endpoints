<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
use Kreatinc\Bot\Models\BotType;
use Kreatinc\Bot\Models\LeadField;

class AddDefaultSellerBotFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sellerBot = BotType::where('slug', 'seller')->first();

        $position = 1;
        foreach ($this->getSellerFields() as &$item) {
            $choices = $item['choices'] ?? [];
            $field = $item['field'];
            $field['type'] = 'seller';
            $field['position'] = $position++;
            $field['created_at'] = Carbon::now();
            $field['updated_at'] = Carbon::now();
            $field['bot_type_id'] = $sellerBot->id;

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
        $sellerBot = BotType::where('slug', 'seller')->first();
        LeadField::where('bot_type_id', $sellerBot->id)->delete();
    }

    public function getSellerFields()
    {
        return [
            [
                'field' => [
                    'title' => 'Property to Sell',
                    'entity_key' => 'property',
                    'entity_type' => '',
                    'question' => 'What are you selling?'
                ],
                'choices' => [
                    [
                        'type' => 'text',
                        'text' => 'Single Family Residence',
                        'payload' => 'Single Family Residence',
                    ],
                    [
                        'type' => 'text',
                        'text' => 'Condominium',
                        'payload' => 'Condominium',
                    ],
                    [
                        'type' => 'text',
                        'text' => 'Duplex',
                        'payload' => 'Duplex',
                    ],
                    [
                        'type' => 'text',
                        'text' => 'Commercial',
                        'payload' => 'Commercial',
                    ],
                    [
                        'type' => 'text',
                        'text' => 'Lots and land',
                        'payload' => 'Lots and land',
                    ]
                ]
            ],
            [
                'field' => [
                    'title' => 'Selling Date',
                    'entity_key' => 'date',
                    'entity_type' => 'datetime',
                    'question' => 'How soon are you looking to sell?'
                ],
                'choices' => [
                    [
                        'type' => 'text',
                        'text' => 'ASAP',
                        'payload' => 'ASAP',
                    ],
                    [
                        'type' => 'text',
                        'text' => 'In 3 months',
                        'payload' => 'In 3 months',
                    ],
                    [
                        'type' => 'text',
                        'text' => 'In 6 months',
                        'payload' => 'In 6 months',
                    ],
                    [
                        'type' => 'text',
                        'text' => 'In a year',
                        'payload' => 'In a year',
                    ]
                ]
            ],
            [
                'field' => [
                    'title' => 'Price',
                    'entity_key' => 'price',
                    'entity_type' => 'amount_of_money',
                    'question' => 'What is your selling price?'
                ]
            ],
            [
                'field' => [
                    'title' => 'Property address',
                    'entity_key' => 'address',
                    'entity_type' => 'location',
                    'question' => 'What is your property address?|eg. 123 Main Street, New York, NY'
                ],
                'choices' => [
                    [
                        'type' => 'location',
                        'text' => '',
                        'payload' => '',
                    ]
                ]
            ],
            [
                'field' => [
                    'title' => 'Number of Bedrooms',
                    'entity_key' => 'bedrooms',
                    'entity_type' => 'number',
                    'question' => 'How many bedrooms does it have?'
                ],
                'choices' => [
                    [
                        'type' => 'text',
                        'text' => '1',
                        'payload' => '1',
                    ],
                    [
                        'type' => 'text',
                        'text' => '2',
                        'payload' => '2',
                    ],
                    [
                        'type' => 'text',
                        'text' => '3',
                        'payload' => '3',
                    ],
                    [
                        'type' => 'text',
                        'text' => '4',
                        'payload' => '4',
                    ],
                    [
                        'type' => 'text',
                        'text' => '5',
                        'payload' => '5',
                    ]
                ]
            ],
            [
                'field' => [
                    'title' => 'Number of Bathrooms',
                    'entity_key' => 'bathrooms',
                    'entity_type' => 'number',
                    'question' => 'How many bathrooms?'
                ],
                'choices' => [
                    [
                        'type' => 'text',
                        'text' => '1',
                        'payload' => '1',
                    ],
                    [
                        'type' => 'text',
                        'text' => '2',
                        'payload' => '2',
                    ],
                    [
                        'type' => 'text',
                        'text' => '3',
                        'payload' => '3',
                    ],
                    [
                        'type' => 'text',
                        'text' => '4',
                        'payload' => '4',
                    ],
                    [
                        'type' => 'text',
                        'text' => '5',
                        'payload' => '5',
                    ]
                ]
            ],
            [
                'field' => [
                    'title' => 'Lot Size',
                    'entity_key' => 'size',
                    'entity_type' => 'number',
                    'question' => 'What is its Lot Size? (e.g. 1,500sqft)?'
                ]
            ],
            [
                'field' => [
                    'title' => 'Living area',
                    'entity_key' => 'living_area',
                    'entity_type' => 'number',
                    'question' => 'Cool! And what\'s the living area (e.g. 1,500sqft)?'
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
                    'title' => 'Email',
                    'entity_key' => 'email',
                    'entity_type' => '',
                    'question' => 'What\'s your preferred email?'
                ],
                'choices' => [
                    [
                        'type' => 'user_email',
                        'text' => '',
                        'payload' => '',
                    ]
                ]
            ],
        ];
    }
}
