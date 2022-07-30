<?php

namespace Api\Models\Errors;

use Exception;
use Throwable;

class MyException extends Exception
{
    private array $fullError;

    public function __construct(string $message, int $code = 0, ?Throwable $previous = null)
    {
        http_response_code($code);

        parent::__construct($message, $code, $previous);

        $this->fullError = [
            'error' => $this->getMessage(),
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine()
        ];
    }

    public function __toString(): string
    {
        return json_encode($this->fullError);
    }
}
