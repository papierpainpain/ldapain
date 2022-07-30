<?php

namespace App\Models;

use App\Models\Ldap;
use App\Models\Mail;
use App\Models\Errors\MyException;

class UserManager
{
    public static function resetPassword(string $uid)
    {
        $userDN = 'uid=' . $uid . ',' . ENV['ldap']['users'];
        $ldap = new Ldap();

        $password = self::randomPassword(8);

        if (self::goodPassword($password, $password)) {
            $ldif['userPassword'] = $password;

            if ($ldap->modify($userDN, $ldif)) {
                $users = $ldap->search(ENV['ldap']['users'], '(uid=' . $uid . ')');
                $email = $users[0]['mail'][0];
                $subject = "Nouveau mot de passe";
                $message = "Mot de passe réinitialisé pour votre compte $uid. Voici votre nouveau mot de passe (que vous devez changer après !) : $password (changez le via ce lien : https://ldapain.papierpain.fr/";
                Mail::send($subject, $email, $message);
            }
        }

        $ldap->close();
    }

    public static function create(string $uid, string $lastname, string $firstname, string $mail)
    {
        $userDN = 'uid=' . $uid . ',' . ENV['ldap']['users'];
        $ldif['objectClass'] = array('top', 'person', 'inetOrgPerson');
        $ldif['cn'] = $lastname;
        $ldif['sn'] = $firstname;
        $password = self::randomPassword(8);
        $ldif['userPassword'] = $password;
        $ldif['mail'] = $mail;
        $ldif['uid'] = $uid;

        $ldap = new Ldap();

        if ($ldap->add($userDN, $ldif)) {
            $users = $ldap->search(ENV['ldap']['users'], '(uid=' . $uid . ')');
            $email = $users[0]['mail'][0];
            $subject = "Nouveau compte";
            $message = "Nouveau compte LDAPain (vous me devez un café !). Nom d'utilisateur : $uid. Votre mot de passe (que vous devez changer après !) : $password (changez le via ce lien : https://ldapain.papierpain.fr/";
            Mail::send($subject, $email, $message);
        }

        $ldap->close();
    }

    public static function remove(string $uid)
    {
        $userDN = 'uid=' . $uid . ',' . ENV['ldap']['users'];

        $ldap = new Ldap();
        $ldap->remove($userDN);

        $ldap->close();
    }

    public static function getAllUser()
    {
        $users = [];

        $ldap = new Ldap();
        $users = $ldap->search(ENV['ldap']['users'], '(cn=*)');
        $ldap->close();

        return $users;
    }

    private static function randomPassword(int $length)
    {
        $lowChars = 'abcdefghijklmnopqrstuvwxyz';
        $highChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $specChars = '&#@$%§*-=';
        $pwd = '';

        while (strlen($pwd) < $length) {
            $pwd .= random_int(0, 9);

            if (strlen($pwd) < $length) {
                $pwd .= $lowChars[rand(0, strlen($lowChars) - 1)];
            }

            if (strlen($pwd) < $length) {
                $pwd .= $highChars[rand(0, strlen($highChars) - 1)];
            }

            if (strlen($pwd) < $length) {
                $pwd .= $specChars[rand(0, strlen($specChars) - 1)];
            }
        }
        return $pwd;
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
