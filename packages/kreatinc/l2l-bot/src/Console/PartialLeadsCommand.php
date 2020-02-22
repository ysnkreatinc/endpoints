<?php

namespace Kreatinc\Bot\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Support\Facades\Date;
use Kreatinc\Bot\Libraries\L2L\Client as L2LClient;
use Kreatinc\Bot\Chat\Sender\Sender;
use Kreatinc\Bot\Models\Conversation;

class PartialLeadsCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:partial-leads {--hour=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send incompleted conversation data to "Listing To Leads" Api.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Sending incompleted Leads...');

        $hour = (int) $this->option('hour');
        if (!is_numeric($hour)) {
            $hour = 2;
        }

        $conversations = Conversation::whereNotNull('type')
                             // ->whereNull('closed_at')
                             ->where('updated_at', '>', Date::parse('- 5 days'))
                             ->where('updated_at', '<', Date::parse("- {$hour} hours"))
                             ->where('completed', false)
                             ->get();

        foreach ($conversations as $conversation) {
            $this->sendConversation($conversation);

            $conversation->complete();
            $conversation->close();
        }

        $this->info('All uncompleted conversations sent.');
    }

    /**
     * Send the conversation data to "Listings To Leads" API.
     *
     * @return void
     * @throws \Exception
     */
    private function sendConversation($conversation)
    {
        // Client.
        $client = new L2LClient();
        if (is_null($conversation->page) || is_null($conversation->page->agent)) {
            return;
        }

        $client->token($conversation->page->agent->l2l_token);

        // Bot
        $bot = $conversation->page->bot;

        try {
            $sender = new Sender($client, $conversation, $bot);
            $sender->send([
                'bot_id'        => $bot->id,
                'intent_id'     => $conversation->intent_id,
                'page_id'       => $conversation->page->account_id,
                'subscriber_id' => $conversation->leadClient->id
            ]);
        } catch (Exception $e) {
            $this->warn($e->getMessage());
        }
    }
}
