<?php

namespace Kreatinc\Bot\Exceptions;

/**
 * SilentException is used to exit the code without raising an error to the server
 */
class SilentException extends \Exception
{
    /**
     * @param string $message
     * @param int    $code
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
