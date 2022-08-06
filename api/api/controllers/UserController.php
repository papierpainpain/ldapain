<?php

namespace Api\Controllers;

use Api\Models\Api;
use Api\Models\Ldap\User;
use Api\Models\Mail;
use Api\Models\Password;

/**
 * Class UserController
 * 
 * @package Api\Controllers
 */
class UserController
{

    /**
     * @OA\Get(
     *      path="/users", tags={"users"},
     *      summary="Get all users",
     *      operationId="getAllUsers",
     *      description="Returns a list of all users",
     *      security={{"bearerAuth":{}}},
     *      
     *      @OA\Response(
     *          response=200, description="List of users"
     *      ),
     *      @OA\Response(response=403, description="Access denied"),
     *      @OA\Response(response=404, description="Not found")
     * )
     */
    public static function getAllUsers()
    {
        $userObj = new User($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $users = $userObj->getAllUsers();

        if (count($users) > 0) {
            Api::success(200, $users);
        } else {
            Api::error(404, 'Aucun utilisateur trouvé');
        }
    }

    /**
     * @OA\Get(
     *      path="/users/{uid}", tags={"users"},
     *      summary="Get a user by uid",
     *      description="Returns a user by uid",
     *      operationId="getUserByUid",
     *      security={{"bearerAuth":{}}},
     *      
     *      @OA\Parameter(
     *          name="uid", in="path", required=true,
     *          description="Uid of the user to retrieve",
     *          @OA\Schema(type="string")
     *      ),
     *      
     *      @OA\Response(
     *          response=200, description="List of users",
     *          @OA\MediaType(mediaType="application/json")
     *      ),
     *      @OA\Response(response=403, description="Access denied"),
     *      @OA\Response(response=404, description="Not found")
     * )
     */
    public static function getUserById($uid)
    {
        $userObj = new User($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $user = $userObj->getUserById($uid);

        if ($user) {
            Api::success(200, $user);
        } else {
            Api::error(404, 'Utilisateur non trouvé');
        }
    }

    /**
     * @OA\Post(
     *      path="/users", tags={"users"},
     *      summary="Create a user",
     *      description="Create a user",
     *      operationId="createUser",
     *      security={{"bearerAuth":{}}},
     * 
     *      @OA\RequestBody(
     *          description="Create user object",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="uid", description="User uid", type="string"),
     *              @OA\Property(property="cn", description="Lastname", type="string"),
     *              @OA\Property(property="sn", description="Firstname", type="string"),
     *              @OA\Property(property="mail", description="Email", type="string")
     *          )
     *      ),
     *      
     *      @OA\Response(response=201, description="User created"),
     *      @OA\Response(response=400, description="Paramètres manquants (uid, cn, sn, mail)"),
     *      @OA\Response(response=403, description="Access denied"),
     *      @OA\Response(response=409, description="User already exists"),
     *      @OA\Response(response=500, description="Failed to create user")
     * )
     */
    public static function createUser()
    {
        $params = json_decode(file_get_contents('php://input'), true);

        if (!isset($params['uid']) || !isset($params['cn']) || !isset($params['sn']) || !isset($params['mail'])) {
            Api::error(400, 'Paramètres manquants (uid, cn, sn, mail)');
        }

        $userObj = new User($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);

        $user = $userObj->getUserById($params['uid']);

        if ($user) {
            Api::error(409, 'Utilisateur déjà existant');
        } else {
            try {
                $password = Password::generate();
                $user = $userObj->createUser($params['uid'], $params['sn'], $params['cn'], $params['mail'], $password);
                if ($user) {
                    Mail::sendNewAccount($user['mail'], $user['uid'], $password);
                    Api::success(201, 'Utilisateur créé');
                } else {
                    Api::error(500, 'Erreur lors de la création de l\'utilisateur');
                }
            } catch (\Exception $e) {
                Api::error(401, $e->getMessage());
            }
        }
    }

    /**
     * @OA\Put(
     *      path="/users/{uid}", tags={"users"},
     *      summary="Update a user",
     *      description="Update a user",
     *      operationId="updateUser",
     *      security={{"bearerAuth":{}}},
     *      
     *      @OA\Parameter(
     *          name="uid", in="path", required=true,
     *          description="Uid of the user to retrieve",
     *          @OA\Schema(type="string")
     *      ),
     * 
     *      @OA\RequestBody(
     *          description="Update user object",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="cn", description="Lastname", type="string"),
     *              @OA\Property(property="sn", description="Firstname", type="string"),
     *              @OA\Property(property="password", description="Password", type="string")
     *          ),
     *      ),
     *      
     *      @OA\Response(response=200, description="User updated"),
     *      @OA\Response(response=400, description="Missing/Incorrect parameters"),
     *      @OA\Response(response=403, description="Access denied"),
     *      @OA\Response(response=404, description="User not found"),
     *      @OA\Response(response=500, description="Failed to update user")
     * )
     */
    public static function updateUser($uid)
    {
        $params = json_decode(file_get_contents('php://input'), true);

        if (!isset($params['cn']) && !isset($params['sn']) && !isset($params['password'])) {
            Api::error(400, 'Paramètres manquants (cn, sn, password) au moins un doit être renseigné');
        }

        $userObj = new User($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $user = $userObj->getUserById($uid);
        if ($user) {
            if (self::checkPassword($params['password'])) {
                if ($userObj->updateUser($user['dn'], $params['sn'] ?? $user['sn'], $params['cn'] ?? $user['cn'], $user['mail'], $params['password'] ?? null)) {
                    Api::success(200, 'Utilisateur mis à jour');
                } else {
                    Api::error(500, 'Erreur lors de la mise à jour de l\'utilisateur');
                }
            } else {
                Api::error(400, 'Mot de passe invalide (minimum de 8 caractères, au moins un caractère spécial, un chiffre, une lettre majuscule et une lettre minuscule)');
            }
        } else {
            Api::error(404, 'Utilisateur non trouvé');
        }
    }

    /**
     * @OA\Delete(
     *      path="/users/{uid}", tags={"users"},
     *      summary="Delete a user",
     *      description="Delete a user",
     *      operationId="deleteUser",
     *      security={{"bearerAuth":{}}},
     *      
     *      @OA\Response(response=200, description="User deleted"),
     *      @OA\Response(response=403, description="Access denied"),
     *      @OA\Response(response=404, description="User not found"),
     *      @OA\Response(response=500, description="User could not be deleted")
     * )
     */
    public static function deleteUser($uid)
    {
        $userObj = new User($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $user = $userObj->getUserById($uid);
        if ($user) {
            if ($userObj->deleteUser($user['dn'])) {
                Api::success(200, 'Utilisateur supprimé');
            } else {
                Api::error(500, 'Erreur lors de la suppression de l\'utilisateur');
            }
        } else {
            Api::error(404, 'Utilisateur non trouvé');
        }
    }

    /**
     * @OA\Put(
     *      path="/users/reset-pwd/{uid}", tags={"users"},
     *      summary="Reset a user password",
     *      description="Reset a user password",
     *      operationId="resetUserPwd",
     *      security={{"bearerAuth":{}}},
     *      
     *      @OA\Parameter(
     *          name="uid", in="path", required=true,
     *          description="Uid of the user to retrieve",
     *          @OA\Schema(type="string")
     *      ),
     *      
     *      @OA\Response(response=200, description="User password reset"),
     *      @OA\Response(response=400, description="Missing/Incorrect parameters"),
     *      @OA\Response(response=403, description="Access denied"),
     *      @OA\Response(response=404, description="User not found"),
     *      @OA\Response(response=500, description="Failed to update user")
     * )
     */
    public static function resetUserPwd($uid)
    {
        $userObj = new User($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $user = $userObj->getUserById($uid);
        if ($user) {
            try {
                $password = Password::generate();
                $status = $userObj->resetPassword($user['dn'], $password);
                if ($status) {
                    Mail::sendPasswordReset($user['mail'], $user['uid'], $password);
                    Api::success(200, ['success' => 'Mot de passe réinitialisé']);
                } else {
                    Api::error(500, 'Erreur lors de la réinitialisation du mot de passe');
                }
            } catch (\Exception $e) {
                Api::error(401, $e->getMessage());
            }
        } else {
            Api::error(404, 'L\'utilisateur n\'a pas été trouvé');
        }
    }

    private static function checkPassword($password)
    {
        if (strlen($password) < 8) {
            return false;
        }
        if (!preg_match("#[0-9]+#", $password)) {
            return false;
        }
        if (!preg_match("#[a-zA-Z]+#", $password)) {
            return false;
        }
        if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $password)) {
            return false;
        }
        return true;
    }
}
