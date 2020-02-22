<?php

namespace Kreatinc\Bot\Libraries\Facebook;

class MessengerProfile
{
    private $data;

    public function __construct()
    {
        $this->data = [];
    }

    /**
     * @param  array   $content
     * @return void
     */
    public function addPersistentMenu(array $content)
    {
        // TODO me/messenger_profile

        return $this;
    }

    /**
     * @param  array   $content
     * @return void
     */
    public function addGetStarted(array $content)
    {
        $this->data['get_started'] = $content;

        return $this;
    }

    public function toArray()
    {
        return $this->data;
    }
}
