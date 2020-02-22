<?php

namespace Kreatinc\Bot\Chat;

use Illuminate\Support\Str;
use Kreatinc\Bot\Libraries\Actions\ActionsManager;
use Kreatinc\Bot\Libraries\ApplyRules;

trait ChatManagerMain
{
    /**
     * Reply with self introduction message.
     *
     * @return \Kreatinc\Bot\Contracts\Messaging
     */
    public function replyWithSelfIntroductionMessage()
    {
        $this->conversation->setNextStep('type');
        if (empty($this->replaceVars)) {
            $this->setReplaceVars($this->conversation);
        }

        $greeting = $this->bot->getGreeting();

        return $this->replyWithServicesTypes($this->fillPlaceHolders($greeting));
    }

    protected function fillPlaceHolders($texts)
    {
        if (!is_array($texts)) {
            $texts = devide_msg($texts);
        }
        // Replace the dynamic variables in the message
        $finalText = [];
        foreach ($texts as $text) {
            foreach ($this->replaceVars as $attr => $value) {
                $text = str_replace('{{'. $attr .'}}', $value, $text);
            }
            $finalText[] = $text;
        }
        return $finalText;
    }

    /**
     *
     * Reply with the bot services.
     * It's the bot types like: Buyer, Seller, Home Valuation.
     *
     * @param  string|array $text
     * @return \Kreatinc\Bot\Contracts\Messaging
     */
    public function replyWithServicesTypes($text = 'How can I help you?')
    {
        $this->messagingTool->sendAllButKeepLast($text);

        foreach ($this->bot->selectableIntents as $intent) {
            $this->messagingTool->addQuickButton('text', $intent->getLabel(), $intent->getWitValue());
        }
        $this->messagingTool->addQuickButton('text', config('bot.sentences.quick_replies.request_agent'), 'human');
        $this->messagingTool->send();
    }

    /**
     * Send seen request to the Messenger and send bubble reply.
     * Also notify Messenger that we stopped typing.
     *
     * @return bool
     */
    public function replyWithUnsupportedMessage()
    {
        // $this->messagingTool->isTypingStop();

        return true;
    }

    /**
     * Prepare the reply to send it to the user.
     *
     * @param  string  $data
     * @param  bool    $isQuickReply
     * @param  string  $entity
     * @param  bool    $toNextField
     * @return \Kreatinc\Bot\Contracts\Messaging
     */
    public function prepareReply($data, $isQuickReply, $entity = null, $toNextField = false)
    {
        if (empty($this->replaceVars)) {
            $this->setReplaceVars($this->conversation);
        }
        // Verify the question before we send it.
        // We ask for confirmation if the user send unsupported message type.
        if ($entity !== 'type' && $toNextField === false) {
            $currentField = $this->conversation->currentField();
            
            if ($isQuickReply !== true) {
                $rawText = data_get($this->conversation, 'currentMessage.body', $data);
                if (! $currentField->isValidEntity($entity, $data, $rawText)) {
                    // We need here to keep track of how many times we verify the current field.
                    // So, we will increment the "verify_counter" column.
                    // When we moved to another field we will reset that counter.
                    // After two attempts we will store the current data and move to the next field.
                    if ($this->conversation->verify_counter === 0) {
                        // Send a message to ask the user to verify.
                        $this->messagingTool->sendAllButKeepLast($this->fillPlaceHolders($currentField->getCatchErrorLevelOne()));
                        foreach ($currentField->fieldChoices as $choice) {
                            $this->messagingTool->addQuickButton($choice->type, $choice->text, $choice->payload);
                        }
                        // Increment the error level
                        $this->conversation->increment('verify_counter');
                        return $this->messagingTool->send();

                    } elseif ($this->conversation->verify_counter === 1) {
                        $this->messagingTool->sendAllButKeepLast($this->fillPlaceHolders($currentField->getCatchErrorLevelTwo($rawText)))
                                            // ->addQuickButton('text', config('bot.sentences.quick_replies.confirm_continue'), $rawText)
                                            ->addQuickButton('text', config('bot.sentences.quick_replies.skip'), 'skip')
                                            ->addQuickButton('text', config('bot.sentences.quick_replies.request_agent'), 'human')
                                            ->addQuickButton('text', config('bot.sentences.quick_replies.restart'), 'restart');

                        foreach ($currentField->fieldChoices as $choice) {
                            $this->messagingTool->addQuickButton($choice->type, $choice->text, $choice->payload);
                        }
                        // Increment the error level
                        $this->conversation->increment('verify_counter');
                        return $this->messagingTool->send();
                    }
                }
                if ($currentField->acceptsRawValue()) {
                    $data = $rawText;
                }
            }
            $this->conversation->addLeadData($this->conversation->step, $data);
            // Reset the verify counter to 0 for next field
            $this->conversation->update(['verify_counter' => 0]);

            $this->messagingTool->sendAllButKeepLast($this->fillPlaceHolders($currentField->getRepliesAfter()))->send();
            if ($currentField->hasActions()) {
                $actions = ActionsManager::make($this, $currentField->actions);
                $actions->doAll();
            }

            if ($currentField->repliesRules->isNotEmpty()) {
                $rules = ApplyRules::make($this->conversation, $currentField->repliesRules);
                $rules->applyAll();
                $this->messagingTool->sendAllButKeepLast($rules->rulesReplies())->send();
            }
        } elseif ($entity === 'type') {
            // This is triggered once after the user select the intent
            $this->messagingTool->sendAllButKeepLast($this->fillPlaceHolders($this->conversation->intent->getReplyAfter()))->send();
        }

        $nextField = $this->conversation->nextRemainingField();

        /**
         * Close if we don't have next question.
         */
        if (is_null($nextField)) {
            return $this->closeConversation(true);
        }

        // Set the next question type.
        $this->conversation->setNextStep($nextField->entity_key);

        /**
         * Start sending the questions to the user.
         */
        $this->messagingTool->sendAllButKeepLast($this->fillPlaceHolders($nextField->getQuestions()));

        foreach ($nextField->fieldChoices as $choice) {
            $this->messagingTool->addQuickButton($choice->type, $choice->text, $choice->payload);
        }

        return $this->messagingTool->send();
    }
}
