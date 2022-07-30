<?php

namespace App\Models;

use App\Models\Errors\MyException;
use App\Models\Ldap;

class Account
{
    /**
     * @return $profil|false
     */
    public static function connexion(string $uid, string $pwd)
    {
        if ($uid == "admin") {
            $userDN = ENV['ldap']['user'];
        } else {
            $userDN = 'uid=' . $uid . ',' . ENV['ldap']['users'];
        }
        
        $ldap = new Ldap($userDN, $pwd);
        $profil = $ldap->search(ENV['ldap']['users'], '(uid=' . $uid . ')');
        $ldap->close();

        if ($uid == "admin") {
            $profil[0]['uid'][0] = 'admin';
            $profil[0]['dn'] = ENV['ldap']['user'];
            $profil[0]['userpassword'][0] = '{SSHA}admin';
            $profil[0]['sn'][0] = 'admin';
            $profil[0]['cn'][0] = 'admin';
            $profil[0]['mail'][0] = 'admin';
        }

        return (isset($profil)) ? $profil[0] : false;
    }
}
