<?php

namespace Kreatinc\Bot\Libraries\Facebook;

use Illuminate\Support\Arr;
use Kreatinc\Bot\Contracts\Messaging;

class FacebookMessaging implements Messaging
{
    protected $facebookClient;

    protected $text;
    protected $image_url;
    protected $quick_buttons = [];
    protected $cards = [];

    public function __construct()
    {
        $this->facebookClient = new Client();
    }

    public function to($recipient)
    {
        $this->facebookClient->setRecipient($recipient);

        return $this;
    }

    public function token($token)
    {
        $this->facebookClient->setToken($token);

        return $this;
    }

    public function send()
    {
        $this->isTypingStop();

        $message = [];
        if (! is_null($this->text)) {
            $message['text'] = $this->text;
        }

        if (! is_null($this->image_url)) {
            $message['attachment'] = [
                'type' => 'image',
                'payload' => [
                    'url' => $this->image_url,
                    'is_reusable' => 'true',
                ]
            ];
        }

        if (! empty($this->quick_buttons)) {
            $message['quick_replies'] = $this->quick_buttons;
        }

        if (! empty($this->cards)) {
            $message['attachment'] = [
                'type' => 'template',
                'payload' => [
                    'template_type' => 'generic',
                    'elements' => $this->cards,
                ]
            ];
        }

        if (! empty($message)) {
            $this->facebookClient->sendMessage($message);
        }

        $this->resetMessageItems();

        return $this;
    }

    public function resetMessageItems()
    {
        $this->text = null;
        $this->quick_buttons = [];
        $this->cards = [];
        $this->image_url = null;
    }

    public function text($content)
    {
        $this->isTypingStart();

        $this->text = $content;

        return $this;
    }

    /**
     * Send all the messages one by one except the last one, we need to send it along the quick replies
     * @param string|array $content
     */
    public function sendAllButKeepLast($content)
    {
        if (empty($content)) {
            return $this;
        }
        $texts = Arr::wrap($content);
        $last_text = array_pop($texts);

        foreach ($texts as $text) {
            $this->text($text)->send();
        }
        $this->text($last_text);

        return $this;
    }

    /**
     * Quick Reply Button
     */
    public function addQuickButton($type, $title, $payload, $img_url = null)
    {
        $this->quick_buttons[] = [
            'content_type' => $type,
            'title' => $title,
            'payload' => $payload,
            'image_url' => $img_url
        ];

        return $this;
    }

    /**
     * Quick Reply Button
     */
    public function addImage($url)
    {
        $this->image_url = $url;

        return $this;
    }

    /**
     * Location Quick Reply
     */
    public function addLocationQuickButton()
    {
        $this->quick_buttons[] = [
            'content_type' => 'location'
        ];

        return $this;
    }

    public function addPhoneQuickButton()
    {
        $this->quick_buttons[] = [
            'content_type' => 'user_phone_number'
        ];

        return $this;
    }

    public function addEmailQuickButton()
    {
        $this->quick_buttons[] = [
            'content_type' => 'user_email'
        ];

        return $this;
    }

    /**
     * Quick Reply - clickable Card with image
     */
    public function addCard($data)
    {
        $this->cards[] = $data;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserInfo($user_id)
    {
        return $this->facebookClient->getFacebookUser($user_id);
    }

    public function seen()
    {
        return $this->facebookClient->sendSeenAction();
    }

    public function isTypingStart()
    {
        $this->facebookClient->sendIsTypingAction(true);
        sleep(3);
    }

    public function isTypingStop()
    {
        return $this->facebookClient->sendIsTypingAction(false);
    }
}
