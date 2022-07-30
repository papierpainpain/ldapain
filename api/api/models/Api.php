<?php

/*
|--------------------------------------------------------------------------
| Api status code and content return
|--------------------------------------------------------------------------
|
| Class to send status code and content to the client.
|
*/

namespace Api\Models;

class Api
{
    public static function error(int $code, string $message): void
    {
        self::send($code, ['error' => $message]);
    }

    public static function success(?int $code = 200, array|string $data): void
    {
        self::send($code, $data);
    }

    public static function unauthorized(?string $message = 'Unauthorized'): void
    {
        self::error(401, $message);
    }

    public static function forbidden(?string $message = 'Forbidden'): void
    {
        self::error(403, $message);
    }

    public static function notFound(?string $message = 'Not found'): void
    {
        self::error(404, $message);
    }

    public static function send(int $code, array|string $data): void
    {
        http_response_code($code);
        echo json_encode($data);
        exit();
    }
}