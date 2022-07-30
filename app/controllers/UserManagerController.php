<?php

namespace App\Controllers;

use App\Models\{File, UserManager};
use App\Models\Errors\LdapException;
use App\Models\Errors\MyException;
use Exception;

class UserManagerController
{
    private const USERS_LIST_PATH = '/admin/users';

    public static function users()
    {
        $users = UserManager::getAllUser();
        require_once File::page('admin/display-users');
    }

    public static function addUser()
    {
        require_once File::page('admin/add-user');
    }

    public static function addUserStore()
    {
        $header = '/admin/add-user';
        try {
            UserManager::create(
                $_POST['uid'],
                $_POST['lastname'],
                $_POST['firstname'],
                $_POST['mail']
            );
            $_SESSION['success'] = 'L\'utilisateur ' . $_POST['uid'] . ' a été ajouté !';
            $header = self::USERS_LIST_PATH;
        } catch (LdapException $e) {
            $_SESSION['error'] = $e->getFullError();
        } finally {
            header("Location: $header");
        }
    }

    public static function delUser(string $uid)
    {
        $header = self::USERS_LIST_PATH;
        try {
            UserManager::remove($uid);
            $_SESSION['success'] = 'L\'utilisateur ' . $uid . ' a été supprimé !';
        } catch (LdapException $e) {
            $_SESSION['error'] = $e->getFullError();
        } finally {
            header("Location: $header");
        }
    }

    public static function resetPwd(string $uid)
    {
        $header = self::USERS_LIST_PATH;
        try {
            UserManager::resetPassword($uid);
            $_SESSION['success'] = 'Le mot de passe de ' . $uid . ' a été changé !';
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
}
