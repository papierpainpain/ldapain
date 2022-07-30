<?php

use App\Models\Router\Router;
use App\Middlewares\Auth;

$connected = Auth::isConnected();
$admin = Auth::isAdmin();

$router = new Router($_SERVER['REQUEST_URI']);


// *** HOME *** //
$router->get('', 'App\Controllers\HomeController::home');


// *** LOGIN *** //
$loginCont = 'App\Controllers\LoginController';

$router->post('/login', $loginCont . '::loginStore');
$router->get('/logout', $loginCont . '::logout');


// *** USER CONNECT *** //
$userCont = 'App\Controllers\UserController';

$router->get('/reset-pwd', $userCont . '::resetPwd');
$router->post('/reset-pwd', $userCont . '::resetPwdStore');

if ($connected && !$admin) {
    $router->get('/profil', $userCont . '::profil');
    
    $router->get('/change-pwd', $userCont . '::changePwd');
    $router->post('/change-pwd', $userCont . '::changePwdStore');
}


// *** ADMIN *** //
$userManagCont = 'App\Controllers\UserManagerController';

if ($admin) {
    $router->get('/admin/users', $userManagCont . '::users');

    $router->get('/admin/add-user', $userManagCont . '::addUser');
    $router->post('/admin/add-user', $userManagCont . '::addUserStore');

    $router->get('/admin/del-user/:uid', $userManagCont . '::delUser');
    $router->get('/admin/reset-pwd/:uid', $userManagCont . '::resetPwd');
}

$router->run();
