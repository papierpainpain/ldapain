<?php

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
|
| API routes to manage LDAP users.
|
*/

use Api\Models\Router\Router;
use Api\Middlewares\Auth;

$router = new Router($_SERVER['REQUEST_URI']);

$admin = Auth::isAdmin();
$auth = Auth::isAuthenticated();

$optionsController = '\Api\Controllers\OptionsController';

// *** USER APIS *** //

$userController = 'Api\Controllers\UserController';

$router->get('users/', $userController . '::getAllUsers', $admin);
$router->post('users/', $userController . '::createUser', $admin);
$router->get('users/:id', $userController . '::getUserById', $admin);
$router->put('users/:id', $userController . '::updateUser', $admin);
$router->delete('users/:id', $userController . '::deleteUser', $admin);

$router->options('users/', $optionsController . '::allow');
$router->options('users/:id', $optionsController . '::allow');

// *** GROUP APIS *** //

$groupController = 'Api\Controllers\GroupController';

$router->get('groups/', $groupController . '::getAllGroups', $admin);
$router->post('groups/', $groupController . '::createGroup', $admin);
$router->get('groups/:id', $groupController . '::getGroupById', $admin);
$router->put('groups/:id', $groupController . '::updateGroup', $admin);
$router->delete('groups/:id', $groupController . '::deleteGroup', $admin);
$router->put('groups/:uid/users', $groupController . '::addUsersToGroup', $admin);
$router->delete('groups/:uid/users', $groupController . '::deleteUsersToGroup', $admin);

$router->options('groups/', $optionsController . '::allow');
$router->options('groups/:id', $optionsController . '::allow');
$router->options('groups/:uid/users', $optionsController . '::allow');

// *** PROFILE APIS *** //

$profileController = 'Api\Controllers\ProfileController';

$router->put('profile', $profileController . '::updateProfile', $auth);
$router->put('profile/password/reset', $profileController . '::resetPassword', true);
$router->put('profile/password', $profileController . '::updatePassword', $auth);

$router->options('profile', $optionsController . '::allow');
$router->options('profile/password/reset', $optionsController . '::allow');
$router->options('profile/password', $optionsController . '::allow');

// *** TOKEN APIS *** //

$tokenController = 'Api\Controllers\TokenController';

$router->post('token', $tokenController . '::generateToken', true);

$router->options('token', $optionsController . '::allow');

// *** SWAGGER *** //
if ($_ENV['APP_ENV'] == 'dev') {
    $swaggerController = 'Api\Controllers\SwaggerController';
    $router->get('swagger.yaml', $swaggerController . '::getSwagger', true);
}


$router->run();
