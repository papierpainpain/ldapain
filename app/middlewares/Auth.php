<?php

namespace App\Middlewares;

class Auth
{
    /**
     * Return if the user is admin
     * 
     * @return bool
     */
    public static function isAdmin(): bool
    {
        return (isset($_SESSION['uid']) && ($_SESSION['dn'] == ENV['ldap']['user']) && self::isConnected());
    }

    /**
     * Return if the user is connected
     * 
     * @return bool
     */
    public static function isConnected(): bool
    {
        return (isset($_SESSION['token']) && substr($_SESSION['token'], 0, strlen('{SSHA}')) === '{SSHA}');
    }
}
