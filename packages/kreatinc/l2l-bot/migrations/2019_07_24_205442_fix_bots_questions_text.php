<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Kreatinc\Bot\Models\BotType;
use Kreatinc\Bot\Models\LeadField;

class FixBotsQuestionsText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Price
        $this->getBotFields('general', ['entity_key' => 'price', 'type' => 'buyer'])->update(['question' => "Okay! What's your preferred price?"]);
        // Size
        LeadField::where('entity_key', 'size')->update(['question' => 'What is its Lot Size?|Eg. 1,500sqft']);
        // Email
        LeadField::where('entity_key', 'email')->update(['question' => 'Which email address shall we use to notify you? 📧']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Price
        $this->getBotFields('general', ['entity_key' => 'price', 'type' => 'buyer'])->update(['question' => 'Okay! What is your selling price?']);
        // Size
        LeadField::where('entity_key', 'size')->update(['question' => 'What is its Lot Size? (e.g. 1,500sqft)?']);
        // Email
        LeadField::where('entity_key', 'email')->update(['question' => 'What is your preferred email?']);
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
