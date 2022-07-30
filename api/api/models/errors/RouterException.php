<?php

namespace Api\Models\Errors;

/**
 *
 */
class RouterException extends MyException
{
    public function __construct(string $message, int $code = 0)
    {
        parent::__construct($message, $code);
    }
}
