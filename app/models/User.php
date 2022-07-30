<?php

namespace App\Models;

use App\Models\Ldap;
use App\Models\Errors\MyException;

class User
{
    public static function changePassword(string $uid, string $oldpwd, string $newpwd, string $newpwdcnf)
    {
        $userDN = 'uid=' . $uid . ',' . ENV['ldap']['users'];
        $ldap = new Ldap($userDN, $oldpwd);

        if (self::goodPassword($newpwd, $newpwdcnf)) {
            $ldif['userPassword'] = $newpwd;

            $ldap->modify($userDN, $ldif);
        }

        $ldap->close();
    }

    private static function goodPassword(string $newpwd, string $newpwdcnf)
    {
        if ($newpwd != $newpwdcnf) {
            throw new MyException("Error E102 - Les mots de passe ne correspondent pas", 523);
        }
        if (strlen($newpwd) < 8) {
            throw new MyException("Error E103 - Le nouveau mot de passe est trop court.<br/>Il doit comporter au moins 8 caractères.", 523);
        }
        if (!preg_match("/[0-9]/", $newpwd)) {
            throw new MyException("Error E104 - Le nouveau mot de passe doit contenir au moins un chiffre.", 523);
        }
        if (!preg_match("/[a-zA-Z]/", $newpwd)) {
            throw new MyException("Error E105 - Le nouveau mot de passe doit contenir au moins une lettre.", 523);
        }
        if (!preg_match("/[A-Z]/", $newpwd)) {
            throw new MyException("Error E106 - Le nouveau mot de passe doit contenir au moins une lettre en majuscules.", 523);
        }
        if (!preg_match("/[a-z]/", $newpwd)) {
            throw new MyException("Error E107 - Le nouveau mot de passe doit contenir au moins une lettre en minuscule.", 523);
        }
        return true;
    }
}
