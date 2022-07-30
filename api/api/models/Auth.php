<?php

namespace Api\Models;

use Api\Models\Ldap\Group;
use Api\Models\Ldap\Ldap;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class Auth
{
    private $user;

    public function __construct(string $username, string $password)
    {
        $ldap = new Ldap('uid=' . $username . ',' . $_ENV['LDAP_USERS_BASE'], $password);

        $this->user = $ldap->search($_ENV['LDAP_USERS_BASE'], '(uid=' . $username . ')', ['uid', 'dn', 'cn', 'sn', 'mail', 'userpassword']);

        $ldap->close();
    }

    public function generateToken()
    {
        $groupObj = new Group($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);

        $data = [
            'uid' => $this->user[0]['uid'][0],
            'dn' => $this->user[0]['dn'],
            'cn' => $this->user[0]['cn'][0],
            'sn' => $this->user[0]['sn'][0],
            'mail' => $this->user[0]['mail'][0],
            'groups' => $groupObj->getGroupsNameByUser($this->user[0]['dn']),
            'password' => $this->user[0]['userpassword'][0]
        ];

        $token = [
            "iss" => $_ENV['JWT_ISSUER'],
            "aud" => $_ENV['JWT_AUDIENCE'],
            "iat" => time(),
            "nbf" => time(),
            'exp' => time() + 3600,
            "data" => $data
        ];

        return JWT::encode($token, $_ENV['JWT_SECRET'], $_ENV['JWT_ALGORITHM']);
    }

    public static function setToken(array $tokenData, string $sn, string $cn): string
    {
        $data = [
            'uid' => $tokenData['uid'],
            'dn' => $tokenData['dn'],
            'cn' => $cn,
            'sn' => $sn,
            'mail' => $tokenData['mail'],
            'groups' => $tokenData['groups'],
            'password' => $tokenData['password']
        ];

        $token = [
            "iss" => $_ENV['JWT_ISSUER'],
            "aud" => $_ENV['JWT_AUDIENCE'],
            "iat" => time(),
            "nbf" => time(),
            'exp' => time() + 3600,
            "data" => $data
        ];

        return JWT::encode($token, $_ENV['JWT_SECRET'], $_ENV['JWT_ALGORITHM']);
    }

    public static function getTokenData(): ?array
    {
        $token = getallheaders()['Authorization'] ?? null;

        if (!$token) {
            return null;
        }

        $token = str_replace('Bearer ', '', $token);

        try {
            $key = new Key($_ENV['JWT_SECRET'], $_ENV['JWT_ALGORITHM']);
            $data = JWT::decode($token, $key);

            if (time() >= $data->exp) {
                return null;
            }

            return (array) $data->data;
        } catch (\Exception $e) {
            return null;
        }
    }
}
