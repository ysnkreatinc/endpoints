<?php

namespace Kreatinc\Bot\Libraries\Facebook;

use Kreatinc\Bot\Contracts\Incoming;
use Illuminate\Support\Arr;

class IncomingMessage implements Incoming
{
    /**
     * Create a new IncomingMessage instance.
     *
     * @param  string  $page_id
     * @param  array   $content
     * @return void
     */
    public function __construct($page_id, array $content)
    {
        $this->page_id   = $page_id;
        $this->content   = $content;
        $this->message   = Arr::get($content, 'message');
        $this->postback  = Arr::get($content, 'postback');
        $this->referral  = Arr::get($content, 'referral');
        $this->sender    = $content['sender']['id'];
        $this->recipient = $content['recipient']['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function isEcho()
    {
        return Arr::get($this->message, 'is_echo') === true || $this->page_id === $this->sender;
    }

    public function getMessageID()
    {
        return Arr::get($this->message, 'mid');
    }

    /**
     * Return the current message type.
     *
     * @return string
     */
    public function getType()
    {
        // Attachments
        if (Arr::has($this->message, 'attachments')) {
            return Arr::get($this->message, 'attachments.0.type');
        }

        // Text
        if (Arr::has($this->message, 'text')) {
            return 'text';
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getPageID()
    {
        return $this->page_id;
    }

    /**
     * @inheritdoc
     */
    public function getTimestamp()
    {
        return Arr::get($this->content, 'timestamp');
    }

    /**
     * Sometimes the page is the one sending the message, so make sure this field is always the user the bot is communicating with
     */
    public function getCustomerID()
    {
        return $this->sender !== $this->page_id ? $this->sender : $this->recipient;
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function hasText()
    {
        return isset($this->message['text']);
    }

    public function getText()
    {
        return Arr::get($this->message, 'text');
    }

    public function hasQuickReply()
    {
        return isset($this->message['quick_reply']['payload']);
    }

    /**
     * Checks if the response has postback reply.
     *
     * @return boolean
     */
    public function hasPostback()
    {
        return isset($this->postback['payload']);
    }

    public function getQuickReplyPayload()
    {
        return Arr::get($this->message, 'quick_reply.payload');
    }

    public function hasLocation()
    {
        return Arr::get($this->message, 'attachments.0.type') === 'location';
    }

    public function getLocationPayload()
    {
        return json_encode(Arr::get($this->message, 'attachments.0.payload'));
    }

    public function getLocationUrl()
    {
        return json_encode(Arr::get($this->message, 'attachments.0.url'));
    }

    /**
     * Get the postback content.
     *
     * @return array
     */
    public function getPostback()
    {
        return $this->postback;
    }

    /**
     * Get only the payload from postback content.
     *
     * @return string
     */
    public function getPostbackPayload()
    {
        return Arr::get($this->postback, 'payload');
    }

    /**
     * Get only the title from postback.
     *
     * @return string
     */
    public function getPostbackTitle()
    {
        return Arr::get($this->postback, 'title');
    }

    /**
     * Checks if this is a new message from the chat widget
     *
     * @return boolean
     */
    public function isFirstFromChatWidget()
    {
        return Arr::get($this->referral, 'source') === 'CUSTOMER_CHAT_PLUGIN';
    }

    public function getMainContent()
    {
        if ($this->hasText()) {
            return $this->getText();
        }
        if ($this->hasQuickReply()) {
            return $this->getQuickReplyPayload();
        }
        if ($this->hasLocation()) {
            return $this->getLocationPayload();
        }
        if ($this->hasPostback()) {
            return $this->getPostbackTitle() ?? $this->getPostbackPayload();
        }

        return json_encode($this->message) ?? '';
    }

    /**
     * Check if the message is coming from the Admin, with an order to "stop the bot"
     *
     * @return boolean
     */
    public function isAnOrderToStop()
    {
        $text = $this->getText();

        $stopSentences = [
            '/Sto(p|pped|pping) The Bot/i',
            '/Let me help you/i',
            '/I can help you/i',
        ];

        foreach ($stopSentences as $sentence) {
            if (preg_match($sentence, $text) === 1) {
                return true;
            }
        }

        return false;
    }
}
