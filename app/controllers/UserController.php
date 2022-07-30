<?php

namespace App\Controllers;

use App\Models\{File, User, UserManager};
use App\Models\Errors\LdapException;
use App\Models\Errors\MyException;
use Exception;

class UserController
{
    public static function profil()
    {
        require_once File::page('account/profil');
    }

    public static function changePwd()
    {
        require_once File::page('account/change-pwd');
    }

    public static function changePwdStore()
    {
        $header = '/change-pwd';
        try {
            User::changePassword(
                $_POST['uid'],
                $_POST['oldpwd'],
                $_POST['newpwd'],
                $_POST['newpwdcnf']
            );
            $_SESSION['success'] = 'Mot de passe modifié !';
            $header = '/profil';
        } catch (LdapException $e) {
            $_SESSION['error'] = $e->getFullError();
        } catch (MyException $e) {
            $_SESSION['error'] = $e->getFullError();
        } catch (Exception $e) {
            $_SESSION['error'] = $e;
        } finally {
            header("Location: $header");
        }
    }

    public static function resetPwd()
    {
        require_once File::page('account/reset-pwd');
    }

    public static function resetPwdStore()
    {
        $header = '/';
        try {
            UserManager::resetPassword($_POST['uid']);
            $_SESSION['success'] = 'Mot de passe modifié !';
        } catch (LdapException $e) {
            $_SESSION['error'] = $e->getFullError();
        } catch (MyException $e) {
            $_SESSION['error'] = $e->getFullError();
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        } finally {
            header("Location: $header");
        }
    }
}
