<?php

namespace Api\Controllers;

/**
 * Class OptionsController
 * 
 * @package Api\Controllers
 */
class OptionsController
{

    /**
     * 
     */
    public static function allow()
    {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Max-Age: 86400');
        header('Content-Length: 0');
        http_response_code(204);
    }
}
