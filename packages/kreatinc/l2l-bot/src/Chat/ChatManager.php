<?php

namespace Kreatinc\Bot\Chat;

use Illuminate\Support\Arr;
use Kreatinc\Bot\Contracts\Messaging;
use Kreatinc\Bot\Contracts\Incoming;
use Kreatinc\Bot\Models\Page;
use Kreatinc\Bot\Models\LeadClient;
use Kreatinc\Bot\Models\Conversation;
use Kreatinc\Bot\Models\Intent;
use Kreatinc\Bot\Models\Message;
use Kreatinc\Bot\Libraries\Wit;
use Kreatinc\Bot\Libraries\L2L\Client as L2LClient;
use Kreatinc\Bot\Exceptions\SilentException;
use Kreatinc\Bot\Chat\Postback\Postback;
use Kreatinc\Bot\Chat\Sender\Sender;

class ChatManager
{
    use ChatManagerMain;

    /** @var \Kreatinc\Bot\Models\Conversation */
    public $page;

    /** @var \Kreatinc\Bot\Models\LeadClient */
    public $customer;

    /** @var \Kreatinc\Bot\Models\Conversation */
    public $conversation;

    /** @var \Kreatinc\Bot\Contracts\Incoming */
    protected $message;

    /** @var \Kreatinc\Bot\Contracts\Messaging */
    public $messagingTool;

    /** @var \Kreatinc\Bot\Libraries\L2L\Client */
    public $l2lClient;

    /** @var \Kreatinc\Bot\Models\Bot */
    public $bot;

    protected $replaceVars = [];

    public function __construct(Messaging $messagingTool)
    {
        $this->messagingTool = $messagingTool;
        // Used get the meaning of the user's messages
        $this->interpreter = new Wit();
        // Used to connect to l2l API
        $this->l2lClient = new L2LClient();
    }

    /**
     * This is the main function we use to handle all incoming messages types from Facebook
     *
     * @param \Kreatinc\Bot\Contracts\Incoming $message
     */
    public function handleIncomingMessage(Incoming $message)
    {
        $this->message = $message;
        // Retrieve all the connected info we need: The Bot, Page and Facebook user
        $this->initBot($message);

        // Stop the bot if the bot status is off.
        if ($this->bot->status === false || $this->customer->hasStoppedTheBot() || $this->bot->hasNoIntents()) {
            return;
        }

        // Detect the current conversation or initiate a new one, between the user and the page
        $this->conversation = $this->retrieveConversation($this->page->id, $this->customer->id, $message);

        // It means this message was sent from our page to the user, by the bot or the page administrators
        if ($message->isEcho()) {
            // We will pause the Bot for an hour
            // if this message was sent from the page admin.
            if (! Arr::has($message->message, 'app_id')
                && $this->page->account_id == $message->getSender()
                && $message->isAnOrderToStop()
            ) {
                // We got a message from the page inbox to stop the bot.
                // $this->conversation->stopConversation();
                $this->customer->stopTheBotPermanently();
            }

            return;
        } else {
            // If the conversation is closed, Just stop the chain.
            // The conversation will be opened if one day has passed.
            if ($this->conversation->isPausedOneDay()) {
                return;
            }
        }

        if ($message->isFirstFromChatWidget()) {
            $this->conversation = $this->conversation->cloneToNew();

            return $this->replyWithSelfIntroductionMessage();
        }

        if ($message->hasPostback()) {
            $postback = new Postback(
                $this->message,
                $this->conversation
            );
            $postback->handle();

            // Get Started
            if ($postback->type() === 'get_started') {
                return $this->replyWithSelfIntroductionMessage();
            }
            // Persistent Menu
            if ($postback->type() === 'menu') {
                return $this->handleRawMessage($message->getPostbackTitle());
            }

            // Here we make the bot started from the postback directly to the type the user want.
            if (Intent::isValidIntent($postback->type())) {
                return $this->handleIntent(
                    $postback->type(),
                    true // isQuickReply
                );
            }

            throw new \Exception('Unknown postback type: '. $message->getPostbackPayload());
        }

        // The user has just started the conversation, or being more than 24H since he messaged
        if ($this->customer->isFirstInWhile($this->conversation->currentMessage->id)) {
            // $this->conversation = $this->conversation->cloneToNew();
        }

        if ($message->hasQuickReply()) {
            return $this->handleIntent(
                $message->getQuickReplyPayload(),
                true // Is Quick Reply
            );
        }

        if ($message->hasLocation()) {
            return $this->handleIntent(
                $message->getLocationPayload(),
                true // Is Quick Reply
            );
        }

        if ($message->hasText()) {
            return $this->handleRawMessage($message->getText());
        }
    }

    public function initBot($message)
    {
        $this->page = $this->retrievePage($message->getPageID());

        $this->messagingTool->token($this->page->access_token);
        $this->messagingTool->to($message->getCustomerID());
        $this->l2lClient->token($this->page->agent->l2l_token);

        $this->bot = $this->page->bot;
        $this->customer = $this->retrieveChatCustomer($this->bot->id, $message->getCustomerID());
    }

    public function messageToSubscriber($pageID, $subscriber, $message)
    {
        $this->page = $this->retrievePage($pageID);

        $this->bot = $this->page->bot;

        if ($this->bot->status === false) {
            return response()->json(['message' => 'The Bot is disabled']);
        }

        // TODO
        $costumer = LeadClient::findByAccountID($subscriber);
        $this->conversation = Conversation::findCurrentByCustomer($this->page->id, $costumer->id);
        $this->conversation->stopConversation();

        $this->messagingTool->token($this->page->access_token);
        $this->messagingTool->to($subscriber);

        return $this->messagingTool->text($message)->send();
    }

    public function retrieveConversation($page_id, $customer_id, $message)
    {
        // If the message already exists, don't respond
        // Facebook will resend the same message if the response is late
        // So we don't want to trait the same message twice
        if (Message::alreadyExists($message->getCustomerID(), $message->getTimestamp())) {
            throw new SilentException('duplicated message');
        }

        $conversation = Conversation::findCurrentByCustomer($page_id, $customer_id);
        $conversation->setCurrentMessage($message);
        $this->setReplaceVars($conversation);

        return $conversation;
    }

    protected function setReplaceVars($conversation)
    {
        $this->replaceVars = [
            'page' => $this->page->name,
            'user_first_name' => $this->customer->first_name,
        ];
        if (is_numeric($this->bot->listing_id)) {
            $address = $conversation->getDataByKey('listing_address_data');
            $original_listing_id = (int)$conversation->getDataByKey('original_listing_id');
            if (empty($address) || $original_listing_id !== $this->bot->listing_id) {
                try {
                    $listing = $this->l2lClient->get("listings/{$this->bot->listing_id}", [
                        'leadForm' => 1,
                    ]);
                    $address = format_address($listing['address'], ['street', 'city', 'state']);
                } catch (\Exception $e) {
                    $address = 'Our Listing';
                }
                $conversation->storeLeadDataByKey('listing_address_data', $address);
                $conversation->storeLeadDataByKey('original_listing_id', $this->bot->listing_id);
            }
            $this->replaceVars['listing_address'] = $address;
        }
        $settings = $this->bot->settings;
        $this->replaceVars['zipcode'] = !empty($settings->zipcode_text) ? $settings->zipcode_text : config('bot.placeholders.zipcode_text');
        $this->replaceVars['footage'] = !empty($settings->footage_unit) ? $settings->footage_unit : config('bot.placeholders.footage_unit');
    }

    public function handleRawMessage($rawText)
    {
        list($text, $entity) = $this->interpreter->getMessageIntent($rawText);

        return $this->handleIntent(
            $text,
            false, // Is Quick Reply
            $entity
        );
    }

    public function handleIntent($data, $isQuickReply = false, $entity = null)
    {
        $this->messagingTool->seen();

        if (in_array($entity, ['thanks', 'bye'])) {
            return $this->messagingTool->text('😊')->send();
        } elseif (in_array($entity, ['welcome', 'greetings'])) {
            //
        } elseif (in_array($data, ['human', 'stop'])) {
            $this->customer->stopTheBotPermanently();
            $this->conversation->complete();
            if ($data === 'stop') {
                $message = config('bot.sentences.stopping');
                $extraData = 'stop.bot';
            } else {
                $message = config('bot.sentences.request_agent');
                $extraData = 'request.agent';
            }
            $this->messagingTool->sendAllButKeepLast($this->fillPlaceHolders($message))->send();

            return $this->sendConversation($extraData);
        }
        if (in_array($data, ['restart'])) {
            $this->conversation = $this->conversation->cloneToNew();
            $this->messagingTool->sendAllButKeepLast($this->fillPlaceHolders(config('bot.sentences.restarting')))->send();
        }
        // TODO use entity = 'intent' to switch conversation

        if (! $this->conversation->hasValidType() && $this->bot->isAcceptedIntent($data)) {
            $this->conversation->setType($data);
            $entity = 'type';
        }
        elseif ($this->conversation->step === 'type' || ! $this->conversation->hasValidType()) {
            if ($this->bot->isAcceptedIntent($data)) {
                $this->conversation->setType($data);
            } elseif ($this->bot->isAcceptedIntent($entity)) {
                $this->conversation->setType($entity);
            }
            $entity = 'type';
        }

        // If we don't have an intent yet, we will resend the greetings
        if (! $this->conversation->hasValidType()) {
            return $this->replyWithSelfIntroductionMessage();
        }

        $this->prepareReply($data, $isQuickReply, $entity);

        return $this;
    }

    public function retrievePage($page_id)
    {
        $page = Page::findByAccountID($page_id);

        return $page;
    }

    public function getChatPage()
    {
        return $this->page;
    }

    public function getChatBot()
    {
        return $this->bot;
    }

    /**
     * Get the lead client from the database, or create new one.
     *
     * @param  int     $bot_id
     * @param  string  $customer_id
     * @return \Kreatinc\Bot\Models\LeadClient
     */
    public function retrieveChatCustomer($bot_id, $customer_id)
    {
        $identifier = [
            'bot_id'     => $bot_id,
            'account_id' => $customer_id,
        ];
        $client = LeadClient::where($identifier)->first();

        if (is_null($client)) {
            $userData = $this->messagingTool->getUserInfo($customer_id);

            // Create new client.
            $client = LeadClient::create(array_merge(
                $identifier,
                [
                    'first_name' => $userData['first_name'],
                    'last_name'  => $userData['last_name'],
                    'profile_pic'  => $userData['profile_pic'] ?? '',
                ]
            ));
        }

        return $client;
    }

    /**
     * Send the conversation data to "Listings To Leads" API.
     *
     * @return void
     * @throws \Exception
     */
    private function sendConversation($extraData = '')
    {
        // TODO refactor Sender
        try {
            $sender = new Sender($this->l2lClient, $this->conversation, $this->bot);

            // We already send the Lead.
            // Now update the Lead in "Listings To Leads".
            if (! is_null($this->conversation->lead_id)) {
                $lead = $sender->send([
                    'bot_id'        => $this->bot->id,
                    'intent_id'     => $this->conversation->intent_id,
                    'page_id'       => $this->conversation->page->account_id,
                    'subscriber_id' => $this->customer->id,
                    'bot_extra_data' => $extraData,
                ], 'PUT', "leads/{$this->conversation->lead_id}");
            } else {
                $lead = $sender->send([
                    'bot_id'        => $this->bot->id,
                    'intent_id'     => $this->conversation->intent_id,
                    'page_id'       => $this->conversation->page->account_id,
                    'subscriber_id' => $this->customer->id,
                    'bot_extra_data' => $extraData,
                ]);
                $this->conversation->update([
                    'lead_id' => $lead['id'],
                ]);
            }
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }

    /**
     * Close the conversation.
     *
     * @param  bool    $complete
     * @param  string  $msg
     * @return \Kreatinc\Bot\Contracts\Messaging
     * @throws \Exception
     */
    public function closeConversation($complete = false, $msg = null)
    {
        // Before we close the conversation.
        // Let's send the data to "Listings To Leads" API.
        $this->sendConversation();

        if ($complete === true) {
            $this->conversation->complete();
        }
        $this->conversation->close();

        // Reply with services...
        return $this->replyWithServicesTypes($msg ?? $this->bot->getClosingMessage());
    }

}
