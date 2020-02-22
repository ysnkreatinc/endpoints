<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kreatinc\Bot\Models\BotType;
use Carbon\Carbon;

class AddBuyerBotTypeAndConversation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create New Bot Type.
        BotType::create([
            'name'        => 'Buyer BOT',
            'slug'        => 'buyer',
            'lead_legend' => 'BOT-B',
        ]);

        // Add the questions for that bot.
        $position = 1;
        foreach ($this->getBuyerFields() as &$item) {
            $choices = $item['choices'] ?? [];
            $field = $item['field'];
            $field['type'] = 'buyer';
            $field['position'] = $position++;
            $field['created_at'] = Carbon::now();
            $field['updated_at'] = Carbon::now();
            $field['bot_type_id'] = BotType::where('slug', 'buyer')->first()->id;

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
        // Remove all bot questions.
        BotType::where('slug', 'buyer')->first()->fields()->delete();

        // Remove the buyer bot type.
        BotType::where('slug', 'buyer')->delete();
    }

    public function getBuyerFields()
    {
        return [
            // Price
            [
                'field' => [
                    'title'       => 'Price',
                    'entity_key'  => 'price',
                    'entity_type' => 'amount_of_money',
                    'question'    => 'Okay! What\'s your preferred price?',
                ]
            ],
            // Footage
            [
                'field' => [
                    'title'       => 'Square Footage',
                    'entity_key'  => 'footage',
                    'entity_type' => 'number',
                    'question'    => 'And what square footage do you prefer?|Eg. 1,500sqft'
                ]
            ],
            // Address
            [
                'field' => [
                    'title' => 'Preferred City/Neighborhoods',
                    'entity_key' => 'address',
                    'entity_type' => 'location',
                    'question' => 'Great! What city or neighborhoods do you prefer?'
                ]
            ],
            // Moving Date
            [
                'field' => [
                    'title' => 'Moving Date',
                    'entity_key' => 'date',
                    'entity_type' => 'datetime',
                    'question' => 'Cool! How soon do you need to move?',
                ],
                'choices' => [
                    ['type' => 'text','text' => 'ASAP','payload' => 'ASAP',],
                    ['type' => 'text','text' => 'In 3 months','payload' => 'In 3 months',],
                    ['type' => 'text','text' => 'In 6 months','payload' => 'In 6 months',],
                    ['type' => 'text','text' => 'In a year','payload' => 'In a year',]
                ]
            ],
            // Prequalified
            [
                'field' => [
                    'title'       => 'Prequalified',
                    'entity_key'  => 'prequalified',
                    'entity_type' => '',
                    'question'    => 'Are you prequalified yet?',
                ],
                'choices' => [
                    ['type'    => 'text','text'    => 'Yes','payload' => 'yes'],
                    ['type'    => 'text','text'    => 'No','payload' => 'no'],
                ]
            ],
            // Quote
            [
                'field' => [
                    'title'       => 'Quote',
                    'entity_key'  => 'quote',
                    'entity_type' => '',
                    'question'    => 'Great! That will help you in your home buying process a lot!|Do you think getting another quote to make sure you have the lowest rate and best terms would be helpful?',
                ],
                'choices' => [
                    ['type'    => 'text','text'    => 'Yes','payload' => 'yes'],
                    ['type'    => 'text','text'    => 'No','payload' => 'no'],
                ]
            ],
            // Prequalified Ready
            [
                'field' => [
                    'title'       => 'Prequalified Ready',
                    'entity_key'  => 'prequalified_ready',
                    'entity_type' => '',
                    'question'    => 'Ok. That sounds great!|Can I help you get prequalified so that when you find a house you love, that you are able to write an offer?… It is free and there is no obligation of course. It just gets you ready is all.',
                ],
                'choices' => [
                    ['type'    => 'text','text'    => 'Yes','payload' => 'yes'],
                    ['type'    => 'text','text'    => 'No','payload' => 'no'],
                ]
            ],
            // Phone Number
            [
                'field' => [
                    'title' => 'Phone number',
                    'entity_key' => 'phone',
                    'entity_type' => 'phone_number',
                    'question' => 'We are almost done! 👍|What’s your phone number? ☎️'
                ],
                'choices' => [
                    ['type' => 'user_phone_number','text' => '','payload' => '']
                ]
            ],
            // Email
            [
                'field' => [
                    'title' => 'Email',
                    'entity_key' => 'email',
                    'entity_type' => '',
                    'question' => 'Which email address shall we use to notify you? 📧'
                ],
                'choices' => [
                    ['type' => 'user_email','text' => '','payload' => '']
                ]
            ],
        ];
    }
}
