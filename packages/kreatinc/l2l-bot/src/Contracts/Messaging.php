<?php

namespace Kreatinc\Bot\Contracts;

interface Messaging
{
    /**
     * Send the data to Facebook Messenger platform.
     *
     * @return \Kreatinc\Bot\Contracts\Messaging
     */
    public function send();

    /**
     * Append a text to send it.
     *
     * @param  string  $content
     * @return \Kreatinc\Bot\Contracts\Messaging
     */
    public function text($content);

    /**
     * Quick Reply Button
     *
     * @param  string  $type
     * @param  string  $title
     * @param  string  $payload
     * @param  string  $img_url
     * @return \Kreatinc\Bot\Contracts\Messaging
     */
    public function addQuickButton($type, $title, $payload, $img_url = null);

    /**
     * Quick Reply clickable Card with image
     *
     * @param  array  $data
     * @return \Kreatinc\Bot\Contracts\Messaging
     */
    public function addCard($data);

    /**
     * Fetch the user informations.
     *
     * @param  string  $user_id
     * @return array
     */
    public function getUserInfo($user_id);
}
