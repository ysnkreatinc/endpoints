<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReplyAfterToIntentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('intents', function (Blueprint $table) {
            $table->text('replies_after')->nullable();
        });

        DB::table('intents')->where('slug', 'buyer')->update([
            'replies_after' => 'Great! Let me help you buy your dream home! 🏡|At any time you can type in \'Talk to human\' to talk to the agent or \'Stop\' to stop the conversation.'
        ]);
        DB::table('intents')->where('slug', 'seller')->update([
            'replies_after' => 'Great! I can certainly help you sell your home! 👍|At any time you can type in \'Talk to human\' to talk to the agent or \'Stop\' to stop the conversation.'
        ]);
        DB::table('intents')->where('slug', 'valuation')->update([
            'replies_after' => 'Great, let me ask you a few questions to determine your home valuation.|At any time you can type in \'Talk to human\' to talk to the agent or \'Stop\' to stop the conversation.'
        ]);
        DB::table('intents')->where('slug', 'listing')->update([
            'label' => 'Get listing information',
            'replies_after' => 'Thank you for requesting more information about {{listing_address}} 🏡|At any time you can type in \'Talk to human\' to talk to the agent or \'Stop\' to stop the conversation.'
        ]);
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
}
