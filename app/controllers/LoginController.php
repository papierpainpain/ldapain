<?php

namespace App\Controllers;

use App\Models\{File, Account};
use App\Models\Errors\{LdapException, MyException};
use Exception;

class LoginController
{
    public static function loginStore()
    {
        $header = '/';
        try {
            $profil = Account::connexion($_POST['uid'], $_POST['pwd']);

            $_SESSION['uid'] = $profil['uid'][0];
            $_SESSION['dn'] = $profil['dn'];
            $_SESSION['token'] = $profil['userpassword'][0];
            $_SESSION['firstname'] = $profil['sn'][0];
            $_SESSION['lastname'] = $profil['cn'][0];
            $_SESSION['mail'] = $profil['mail'][0];
        } catch (LdapException $e) {
            $_SESSION['error'] = $e->getLdapMsg();
        } catch (MyException $e) {
            $_SESSION['error'] = $e->getFullError();
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        } finally {
            header("Location: $header");
        }
    }

    public static function logout()
    {
        session_destroy();
        header("Location: /");
    }
}
