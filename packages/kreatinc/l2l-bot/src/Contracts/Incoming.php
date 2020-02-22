<?php

namespace Kreatinc\Bot\Contracts;

interface Incoming
{
    /**
     * Checks if the message is an echo.
     *
     * @return bool
     */
    public function isEcho();

    /**
     * Page id.
     *
     * @return string
     */
    public function getPageID();

    /**
     * The subscriber id.
     *
     * @return string
     */
    public function getCustomerID();

    /**
     * Get the message timestamp from the response.
     *
     * @return int
     */
    public function getTimestamp();
}
