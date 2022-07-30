<?php

namespace App\Models\Router;

use \App\Models\File;
use \Exception;
use \Throwable;

/**
 *
 */
class RouterException extends Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        require_once File::page('errors/' . $code);
        parent::__construct($message, $code, $previous);
    }
}
