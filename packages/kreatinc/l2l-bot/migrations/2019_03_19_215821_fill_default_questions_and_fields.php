<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FillDefaultQuestionsAndFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $position = 1;
        foreach ($this->getBuyerFields() as $item) {
            $choices = $item['choices'] ?? [];
            $field = $item['field'];
            $field['type'] = 'buyer';
            $field['position'] = $position++;

            $field_id = \DB::table('lead_fields')->insertGetId($field);
            foreach ($choices as $choice) {
                $choice['lead_field_id'] = $field_id;
                \DB::table('field_choices')->insert($choice);
            }
        }

        $position = 1;
        foreach ($this->getSellerFields() as $item) {
            $choices = $item['choices'] ?? [];
            $field = $item['field'];
            $field['type'] = 'seller';
            $field['position'] = $position++;

            $field_id = \DB::table('lead_fields')->insertGetId($field);
            foreach ($choices as $choice) {
                $choice['lead_field_id'] = $field_id;
                \DB::table('field_choices')->insert($choice);
            }
        }

        $position = 1;
        foreach ($this->getValuationFields() as $item) {
            $field = $item['field'];
            $field['type'] = 'valuation';
            // $field['position'] = $position++;

            $field_id = \DB::table('lead_fields')->insertGetId($field);
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

    public function getBuyerFields()
    {
        return [
            [
                'field' => [
                    'title' => 'Property Type',
                    'entity_key' => 'property',
                    'entity_type' => '',
                    'question' => 'What type of property are you looking for?'
                ],
                'choices' => [
                    [
                        'type' => 'text',
                        'text' => 'Residential',
                        'payload' => 'Residential',
                    ],
                    [
                        'type' => 'text',
                        'text' => 'Industrial',
                        'payload' => 'Industrial',
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
                    'title' => 'Price',
                    'entity_key' => 'price',
                    'entity_type' => 'amount_of_money',
                    'question' => 'What price range have you been considering?'
                ]
            ],
            [
                'field' => [
                    'title' => 'Number of Bedrooms',
                    'entity_key' => 'bedrooms',
                    'entity_type' => 'number',
                    'question' => 'How many bedrooms?'
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
                    'question' => 'What size lot do you prefer?'
                ]
            ],
            [
                'field' => [
                    'title' => 'Square Footage',
                    'entity_key' => 'footage',
                    'entity_type' => 'number',
                    'question' => 'What square footage do you prefer?'
                ]
            ],
            [
                'field' => [
                    'title' => 'Preferred City/Address',
                    'entity_key' => 'address',
                    'entity_type' => 'location',
                    'question' => 'What is your preferred city/address?'
                ]
            ],
            [
                'field' => [
                    'title' => 'Moving Date',
                    'entity_key' => 'date',
                    'entity_type' => 'datetime',
                    'question' => 'How soon do you need to move?'
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
                    'question' => 'What is your best email?'
                ],
                'choices' => [
                    [
                        'type' => 'user_email',
                        'text' => '',
                        'payload' => '',
                    ]
                ]
            ],
            // [
            //     'field' => [
            //         'title' => 'Full name',
            //         'entity_key' => 'name',
            //         'entity_type' => 'contact',
            //         'question' => 'What\'s your full name?'
            //     ],
            //     'choices' => [
            //         [
            //             'type' => 'user_full_name',
            //             'text' => '',
            //             'payload' => '',
            //         ]
            //     ]
            // ],
        ];
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
                    'question' => 'What is your property address?'
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
                    'question' => 'What is your professionel email?'
                ],
                'choices' => [
                    [
                        'type' => 'user_email',
                        'text' => '',
                        'payload' => '',
                    ]
                ]
            ],
            // [
            //     'field' => [
            //         'title' => 'Full name',
            //         'entity_key' => 'name',
            //         'entity_type' => 'contact',
            //         'question' => 'What\'s your full name?'
            //     ],
            //     'choices' => [
            //         [
            //             'type' => 'user_full_name',
            //            'text' => '',
            //            'payload' => '',
            //         ]
            //     ]
            // ],
        ];
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
                    'question' => 'What is the property address?',
                    'position' => 3,
                ]
            ],
        ];
    }
}
