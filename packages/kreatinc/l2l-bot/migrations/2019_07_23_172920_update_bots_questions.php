<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Kreatinc\Bot\Models\BotType;
use Kreatinc\Bot\Models\LeadField;

class UpdateBotsQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Footage
        $this->getBotFields('general', ['entity_key' => 'footage'])->update(['question' => 'And what square footage do you prefer?|Eg. 1,500sqft']);
        // Date
        $this->getBotFields('general', ['entity_key' => 'date'])->update(['question' => 'Cool! How soon do you need to move?']);
        $this->getBotFields('seller', ['entity_key' => 'date'])->update(['question' => 'And how soon are you looking to sell?']);
        // Phone Number
        LeadField::where('entity_key', 'phone')->update(['question' => 'We are almost done! 👍|What’s your phone number? ☎️']);
        // Price
        LeadField::where('entity_key', 'price')->update(['question' => 'Okay! What is your selling price?']);
        // Address
        LeadField::where('entity_key', 'address')->update(['question' => 'Great! What is your property address?|Eg. 123 Main Street, New York, NY']);
        $this->getBotFields('general', ['entity_key' => 'address', 'type' => 'buyer'])->update(['question' => 'Great! What city or neighborhoods do you prefer?']);
        // Bathrooms
        LeadField::where('entity_key', 'bathrooms')->update(['question' => 'And how many bathrooms?']);
        // Living Area
        LeadField::where('entity_key', 'living_area')->update(['question' => 'Cool! And what’s the living area?|Eg. 1,500sqft']);
        // Email
        $this->getBotFields('listing', ['entity_key' => 'email'])->update(['question' => 'Which email address shall we use to notify you? 📧']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Footage
        $this->getBotFields('general', ['entity_key' => 'footage'])->update(['question' => 'What square footage do you prefer?']);
        // Date
        $this->getBotFields('general', ['entity_key' => 'date'])->update(['question' => 'How soon do you need to move?']);
        $this->getBotFields('seller', ['entity_key' => 'date'])->update(['question' => 'How soon are you looking to sell?']);
        // Phone Number
        LeadField::where('entity_key', 'phone')->update(['question' => 'What is your phone number?']);
        $this->getBotFields('listing', ['entity_key' => 'phone'])->update(['question' => 'We are almost done! 👍|What’s your phone number? ☎️']);
        // Price
        LeadField::where('entity_key', 'price')->update(['question' => 'What is your selling price?']);
        // Address
        $this->getBotFields('general', ['entity_key' => 'address', 'type' => 'buyer'])->update(['question' => 'What city or neighborhoods do you prefer?']);
        $this->getBotFields('general', ['entity_key' => 'address', 'type' => 'seller'])->update(['question' => 'What is your property address?|eg. 123 Main Street, New York, NY']);
        $this->getBotFields('general', ['entity_key' => 'address', 'type' => 'valuation'])->update(['question' => "What's your property address?\neg. 123 Main Street, New York, NY"]);
        $this->getBotFields('seller', ['entity_key' => 'address'])->update(['question' => 'What is your property address?|eg. 123 Main Street, New York, NY']);
        $this->getBotFields('valuation', ['entity_key' => 'address'])->update(['question' => 'What\'s your property address? eg. 123 Main Street, New York, NY']);
        // Bathrooms
        LeadField::where('entity_key', 'bathrooms')->update(['question' => 'How many bathrooms?']);
        // Living Area
        LeadField::where('entity_key', 'living_area')->update(['question' => "Cool! And what's the living area (e.g. 1,500sqft)?"]);
        // Email
        $this->getBotFields('listing', ['entity_key' => 'email'])->update(['question' => 'Which email address shall we use to notify you? 📧']);
    }

    /**
     * Get Bot Type fields.
     *
     * @param  string  $slug
     * @param  array   $where
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getBotFields(string $slug, array $where)
    {
        return BotType::where('slug', $slug)->first()
                                            ->fields()
                                            ->where($where);
    }
}
