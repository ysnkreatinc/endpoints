<?php

namespace Kreatinc\Bot\Chat\Sender;

use Exception;
use Kreatinc\Bot\Models\Conversation;
use Kreatinc\Bot\Models\Bot;
use Kreatinc\Bot\Libraries\L2L\Client;

use Kreatinc\Bot\Chat\Sender\{SenderData, PrepareBuyer, PrepareSeller, PrepareValuation};

class Sender
{
    use SenderData,
        PrepareBuyer,
        PrepareSeller,
        PrepareValuation;

    /**
     * "Listings To Leads" HTTP Client.
     *
     * @var \Kreatinc\Bot\Libraries\L2L\Client
     */
    private $client;

    /**
     * Conversation model instance.
     *
     * @var \Kreatinc\Bot\Models\Conversation
     */
    private $conversation;

    /**
     * Bot model instance.
     *
     * @var \Kreatinc\Bot\Models\Bot
     */
    private $bot;

    /**
     * The conversation data.
     *
     * @var array
     */
    public $data;

    /**
     * Create a new SendLeads instance.
     *
     * @param  \Kreatinc\Bot\Libraries\L2L\Client  $client
     * @param  \Kreatinc\Bot\Models\Conversation   $conversation
     * @param  \Kreatinc\Bot\Models\Bot            $bot
     * @return void
     */
    public function __construct(Client $client, Conversation $conversation, Bot $bot)
    {
        $this->client = $client;
        $this->conversation = $conversation;
        $this->bot = $bot;

        // Set the conversation data;
        $this->data = $this->data();
    }

    /**
     * Send the conversation data to "Listings To Leads" API.
     *
     * @return array
     * @throws \Exception
     */
    public function send(array $data, string $method = 'POST', string $endpoint = 'leads')
    {
        switch ($this->conversation->type) {
            case 'listing': ;
            case 'buyer':
                // Update subscriber data
                $this->subscriber()->syncData($this->buyer());

                // Send Lead
                return $this->client->$method($endpoint, array_merge($this->buyer(), $data));
            case 'seller':
                // Update subscriber data
                $this->subscriber()->syncData($this->seller());

                // Send Lead
                return $this->client->$method($endpoint, array_merge($this->seller(), $data));
            case 'valuation':
                // If we don't have any valuation, don't send anything.
                $valuation = $this->valuation();

                // Update subscriber data
                $this->subscriber()->syncData($valuation);

                // Send Lead
                return $this->client->$method($endpoint, array_merge($valuation, $data));
            default:
                $data['email'] = $this->subscriber()->email;
                return $this->client->$method($endpoint, $data);
        }
    }

    /**
     * Get the conversation subscriber.
     *
     * @return \Kreatinc\Bot\Models\LeadClient
     */
    public function subscriber()
    {
        return $this->conversation->leadClient;
    }

    /**
     * Get the conversation page.
     *
     * @return \Kreatinc\Bot\Models\Page
     */
    public function page()
    {
        return $this->conversation->page;
    }
}
