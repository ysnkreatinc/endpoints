<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameIntentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function() {
            Schema::rename('bot_types', 'intents');

            Schema::table('intents', function (Blueprint $table) {
                // can be selected for starting bot conversation
                $table->boolean('selectable')->default(true);
                // can add it tp Messenger menu
                $table->boolean('add_to_menu')->default(true);
                $table->string('label')->nullable();
            });

            Schema::create('bot_intents', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('bot_id')->unsigned();
                $table->unsignedBigInteger('intent_id');
                $table->string('label')->nullable();

                $table->unique(['bot_id', 'intent_id']);
                $table->foreign('bot_id')->references('id')->on('bots');
                $table->foreign('intent_id')->references('id')->on('intents');

                $table->timestamps();
            });

            // Fill bot_intents
            $intents = DB::table('intents')->pluck('id', 'slug')->all();

            $bots = DB::table('bots')->where('bot_type_id', '!=', $intents['general'])->get(['id', 'bot_type_id']);
            $bots_insert = [];
            foreach ($bots as $b) {
                $bots_insert[] = [
                    'bot_id' => $b->id,
                    'intent_id' => $b->bot_type_id
                ];
            }
            DB::table('bot_intents')->insert($bots_insert);

            // For general, replace it with all 3 intents
            $bots = DB::table('bots')->where('bot_type_id', $intents['general'])->get(['id']);
            $bots_insert = [];
            foreach ($bots as $b) {
                $bots_insert[] = [
                    'bot_id' => $b->id,
                    'intent_id' => $intents['buyer']
                ];
                $bots_insert[] = [
                    'bot_id' => $b->id,
                    'intent_id' => $intents['seller']
                ];
                $bots_insert[] = [
                    'bot_id' => $b->id,
                    'intent_id' => $intents['valuation']
                ];
            }
            DB::table('bot_intents')->insert($bots_insert);

            // Rename column - drop foreign key - replace removed types
            // for conversations
            Schema::table('conversations', function (Blueprint $table) {
                $table->dropForeign(['bot_type_id']);
                $table->renameColumn('bot_type_id', 'intent_id');
            });
            // Replace general with correct intent
            DB::table('conversations')
                ->where('intent_id', $intents['general'])
                ->where('type', 'buyer')
                ->update(['intent_id' => $intents['buyer']]);

            DB::table('conversations')
                ->where('intent_id', $intents['general'])
                ->where('type', 'seller')
                ->update(['intent_id' => $intents['seller']]);

            DB::table('conversations')
                ->where('intent_id', $intents['general'])
                ->where('type', 'valuation')
                ->update(['intent_id' => $intents['valuation']]);

            DB::table('conversations')
                ->where('intent_id', $intents['general'])
                ->whereNull('type')
                ->update(['intent_id' => null]);

            DB::table('conversations')
                ->where('intent_id', $intents['listing'])
                ->update(['type' => 'listing']);

            // Rename column - drop foreign key - replace removed types
            // for lead_fields
            Schema::table('lead_fields', function (Blueprint $table) {
                $table->dropForeign(['bot_type_id']);
                $table->renameColumn('bot_type_id', 'intent_id');
            });
            $now = now()->toDateTimeString();
            // Delete general fields, since they are duplicated
            DB::table('lead_fields')
                ->where('intent_id', $intents['general'])
                ->update(['deleted_at' => $now]);

            // Replace buyer by listing for the listing fields
            DB::table('lead_fields')
                ->where('intent_id', $intents['listing'])
                ->update(['type' => 'listing']);

            // Drop bot_type_id and remove general
            Schema::table('bots', function (Blueprint $table) {
                $table->dropForeign(['bot_type_id']);
                $table->dropColumn(['bot_type_id']);
                $table->string('intro_text')->nullable();
                $table->string('closing_text')->nullable();
            });

            DB::table('intents')->where('slug', 'general')->delete();

            DB::table('intents')->where('slug', 'buyer')->update(['name' => 'Buyer', 'label' => 'I\'m a Buyer']);
            DB::table('intents')->where('slug', 'seller')->update(['name' => 'Home Seller', 'label' => 'I\'m a Seller']);
            DB::table('intents')->where('slug', 'valuation')->update(['name' => 'Home Valuation', 'label' => 'Get Home Valuation']);
            DB::table('intents')->where('slug', 'listing')->update(['name' => 'Listing', 'label' => 'See our main property']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_data');
    }
}
