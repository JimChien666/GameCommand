<?php

namespace App\Exceptions;

use Exception;

class NumberOutOfRangeException extends Exception
{

    public function __construct(string $message, int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return $this->message;
    }
}
