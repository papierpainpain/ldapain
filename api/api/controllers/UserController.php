<?php

namespace Api\Controllers;

use Api\Models\Ldap\User;

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
            self::send(200, $users);
        } else {
            self::send(404, ['error' => 'Aucun utilisateur trouvé']);
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
            self::send(200, $user);
        } else {
            self::send(404, ['error' => 'Utilisateur non trouvé']);
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
     *              @OA\Property(property="mail", description="Email", type="string"),
     *              @OA\Property(property="password", description="Password", type="string")
     *          )
     *      ),
     *      
     *      @OA\Response(response=201, description="User created"),
     *      @OA\Response(response=400, description="Missing/Incorrect parameters"),
     *      @OA\Response(response=403, description="Access denied"),
     *      @OA\Response(response=409, description="User already exists"),
     *      @OA\Response(response=500, description="Failed to create user")
     * )
     */
    public static function createUser()
    {
        $params = json_decode(file_get_contents('php://input'), true);

        if (!isset($params['uid']) || !isset($params['cn']) || !isset($params['sn']) || !isset($params['mail']) || !isset($params['password'])) {
            self::send(400, ['error' => 'Paramètres manquants (uid, cn, sn, mail, password)']);
        }

        $userObj = new User($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);

        $user = $userObj->getUserById($params['uid']);

        if ($user) {
            self::send(409, ['error' => 'Utilisateur déjà existant']);
        } else {
            if (self::checkPassword($params['password'])) {
                $user = $userObj->createUser($params['uid'], $params['sn'], $params['cn'], $params['mail'], $params['password']);
                if ($user) {
                    self::send(201, $user);
                } else {
                    self::send(500, ['error' => 'Erreur lors de la création de l\'utilisateur']);
                }
            } else {
                self::send(400, ['error' => 'Mot de passe invalide']);
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
            self::send(400, ['error' => 'Paramètres manquants (cn, sn, password) au moins un doit être renseigné']);
        }

        $userObj = new User($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $user = $userObj->getUserById($uid);
        if ($user) {
            if (self::checkPassword($params['password'])) {
                if ($userObj->updateUser($user['dn'], $params['sn'] ?? $user['sn'], $params['cn'] ?? $user['cn'], $user['mail'], $params['password'] ?? null)) {
                    self::send(200, ['success' => 'Utilisateur mis à jour']);
                } else {
                    self::send(500, ['error' => 'Erreur lors de la mise à jour de l\'utilisateur']);
                }
            } else {
                self::send(400, ['error' => 'Mot de passe invalide (minimum de 8 caractères, au moins un caractère spécial, un chiffre, une lettre majuscule et une lettre minuscule)']);
            }
        } else {
            self::send(404, ['error' => 'Utilisateur non trouvé']);
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
                self::send(200, ['success' => 'Utilisateur supprimé']);
            } else {
                self::send(500, ['error' => 'Erreur lors de la suppression de l\'utilisateur']);
            }
        } else {
            self::send(404, ['error' => 'Utilisateur non trouvé']);
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

    private static function send($status, $data)
    {
        http_response_code($status);
        echo json_encode($data);
        exit();
    }
}
