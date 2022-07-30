<?php

namespace Api\Middlewares;

use Api\Models\Auth as ModelsAuth;

class Auth
{
    public static function isAuthenticated(): bool
    {

        return (ModelsAuth::getTokenData() !== null);
    }

    public static function getUserId(): ?int
    {
        $result = null;
        $data = ModelsAuth::getTokenData();

        if ($data) {
            $result = $data['uid'];
        }

        return $result;
    }

    public static function getUserDn(): ?string
    {
        $result = null;
        $data = ModelsAuth::getTokenData();

        if ($data) {
            $result = $data['dn'];
        }

        return $result;
    }

    public static function getUserGroups(): ?array
    {
        $result = null;
        $data = ModelsAuth::getTokenData();

        if ($data) {
            $result = $data['groups'];
        }

        return $result;
    }

    public static function isAdmin(): ?bool
    {
        $result = false;
        $data = ModelsAuth::getTokenData();

        if ($data) {
            $result = in_array($_ENV['LDAP_ADMIN_GROUP'], $data['groups']);
        }

        return $result;
    }
}
