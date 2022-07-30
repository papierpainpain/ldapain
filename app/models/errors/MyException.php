<?php

namespace App\Models\Errors;

use Exception;
use Throwable;

class MyException extends Exception
{
    private string $fullError;

    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        http_response_code($code);
        
        parent::__construct($message, $code, $previous);
        
        $this->fullError = 'ERROR [' .$this->getCode() . '] : ' .$this->getMessage() . '</br>' . $this->getFile() . ' (line ' . $this->getLine() . ')</br></br>';
    }

    public function __toString()
    {
        echo $this->getFullError();
    }

    public function getFullError() {
        return $this->fullError;
    }
}
