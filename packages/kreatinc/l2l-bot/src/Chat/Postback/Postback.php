<?php

namespace Kreatinc\Bot\Chat\Postback;

use Illuminate\Support\Str;
use Kreatinc\Bot\Contracts\Incoming;
use Kreatinc\Bot\Models\Conversation;

class Postback
{
    /**
     * The current message.
     *
     * @var \Kreatinc\Bot\Contracts\Incoming
     */
    public $message;

    /**
     * Conversation Model instance.
     *
     * @var \Kreatinc\Bot\Models\Conversation
     */
    public $conversation;

    /**
     * The type dilimiter that split the type name and value.
     *
     * @var string
     */
    const TYPE_DELIMITER = '.';

    /**
     * Create a new Postback instance.
     *
     * @param  \Kreatinc\Bot\Contracts\Incoming   $message
     * @param  \Kreatinc\Bot\Models\Conversation  $conversation
     * @return boolean
     */
    public function __construct(Incoming $message, Conversation &$conversation)
    {
        $this->message = $message;
        $this->conversation = &$conversation;
    }

    /**
     * Handle the incoming postback and route it to the correct handler.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        // TODO handle all cases in one place: here or outside
        $type = $this->type();

        switch ($type) {
            // Persistent Menu
            case 'menu':
                return $this->persistentMenu();
            // Get Started
            case 'get_started':
                return; // Do nothing with this type.
            // Start the bot from payload.
            case 'buyer':
            case 'seller':
            case 'valuation':
            case 'listing':
                return;
        }
    }

    /**
     * Handle Persistent Menu postback type.
     *
     * @return void
     */
    protected function persistentMenu()
    {
        // TODO new conversation instead of deleting data
        // Delete all the data before we switch.
        $this->conversation->leadData()->delete();

        // This will make sure we always get next field.
        // If the user change the conversation type in the last step
        // We can't get next field.
        $this->conversation->update([
            'type' => null,
            'step' => null,
        ]);

        $this->conversation->setType($this->typeValue());

        // Set the conversation type and next step.
        $nextField = $this->conversation->nextRemainingField();
        $this->conversation->setNextStep($nextField->entity_key);
    }

    /**
     * Get the postback type.
     *
     * @return string|boolean
     */
    public function type()
    {
        return Str::before($this->message->getPostbackPayload(), self::TYPE_DELIMITER);
    }

    /**
     * Get the postback type value.
     *
     * @return string|boolean
     */
    protected function typeValue()
    {
        $value = strstr($this->message->getPostbackPayload(), self::TYPE_DELIMITER);

        // Remove the first char.
        return substr($value, 1);
    }
}
