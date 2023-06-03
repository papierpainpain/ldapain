<?php

namespace Api\Controllers;

use Api\Models\Api;
use Api\Models\Auth;
use Api\Models\Ldap\User;
use Api\Models\Ldap\Group;

use Api\Models\Errors\LdapException;
use Api\Models\Mail;
use Api\Models\Password;

/**
 * Class ProfileController
 * 
 * @package Api\Controllers
 */
class ProfileController
{

    /**
     * @OA\Put(
     *      path="/profile", tags={"profile"},
     *      summary="Update user profile",
     *      operationId="updateProfile",
     *      description="Update user profile",
     *      security={{"bearerAuth":{}}},
     * 
     *      @OA\RequestBody(
     *          description="Update user object",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="cn", description="Lastname", type="string"),
     *              @OA\Property(property="sn", description="Firstname", type="string")
     *          ),
     *      ),
     *      
     *      @OA\Response(response=200, description="User updated"),
     *      @OA\Response(response=400, description="Missing/Incorrect parameters"),
     *      @OA\Response(response=403, description="Vous n'êtes pas autorisé à modifier cet utilisateur"),
     *      @OA\Response(response=404, description="L'utilisateur n'a pas été trouvé"),
     *      @OA\Response(response=500, description="Failed to update user")
     * )
     */
    public static function updateProfile()
    {
        $params = json_decode(file_get_contents('php://input'), true);

        if (!isset($params['cn']) && !isset($params['sn']) && !isset($params['password'])) {
            Api::error(400, 'Paramètres manquants (cn, sn) vous avez besoin au moins un!');
        }

        $userAuth = Auth::getTokenData();
        $ldap = new User($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $user = $ldap->getUserById($userAuth['uid']);

        if ($user) {
            if (self::checkEqual($user, $userAuth)) {
                try {
                    $ldap->updateUser($user['dn'], $params['sn'], $params['cn'], $user['mail']);
                    $token = Auth::setToken($userAuth, $params['sn'], $params['cn']);

                    if ($token) {
                        Api::success(201, [
                            'token' => $token,
                            'user' => $user
                        ]);
                    } else {
                        Api::error(401, 'Erreur lors de la génération du token');
                    }
                } catch (LdapException $e) {
                    Api::error(500, $e->getMessage());
                } catch (\Exception $e) {
                    Api::error(401, $e->getMessage());
                }
            } else {
                Api::error(403, 'Vous n\'êtes pas autorisé à modifier cet utilisateur');
            }
        } else {
            Api::error(404, 'L\'utilisateur n\'a pas été trouvé');
        }
    }

    /**
     * @OA\Put(
     *      path="/profile/password/reset", tags={"profile"},
     *      summary="Reset user password",
     *      operationId="resetPassword",
     *      description="Reset user password",
     * 
     *      @OA\RequestBody(
     *          description="Reset user password",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="uid", description="User ID", type="string"),
     *          ),
     *      ),
     *      
     *      @OA\Response(response=200, description="User password reset"),
     *      @OA\Response(response=400, description="Missing/Incorrect parameters"),
     *      @OA\Response(response=403, description="Vous n'êtes pas autorisé à modifier cet utilisateur"),
     *      @OA\Response(response=404, description="L'utilisateur n'a pas été trouvé"),
     *      @OA\Response(response=500, description="Failed to reset user password")
     * )
     */
    public static function resetPassword()
    {
        $params = json_decode(file_get_contents('php://input'), true);

        if (!isset($params['uid'])) {
            Api::error(400, 'Paramètres manquants (uid) vous avez besoin au moins un!');
        }

        $ldap = new User($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $user = $ldap->getUserById($params['uid']);

        if ($user) {
            try {
                $password = Password::generate();
                $status = $ldap->resetPassword($user['dn'], $password);
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

    /**
     * @OA\Put(
     *      path="/profile/password", tags={"profile"},
     *      summary="Update user password",
     *      operationId="updatePassword",
     *      description="Update user password",
     *      security={{"bearerAuth":{}}},
     * 
     *      @OA\RequestBody(
     *          description="Update user object",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="oldPassword", description="Old password", type="string"),
     *              @OA\Property(property="newPassword", description="New password", type="string"),
     *          ),
     *      ),
     *      
     *      @OA\Response(response=200, description="User updated"),
     *      @OA\Response(response=400, description="Missing/Incorrect parameters"),
     *      @OA\Response(response=403, description="Vous n'êtes pas autorisé à modifier cet utilisateur"),
     *      @OA\Response(response=404, description="L'utilisateur n'a pas été trouvé"),
     *      @OA\Response(response=500, description="Failed to update user")
     * )
     */
    public static function updatePassword()
    {
        $params = json_decode(file_get_contents('php://input'), true);

        if (!isset($params['oldPassword']) && !isset($params['newPassword'])) {
            Api::error(400, 'Paramètres manquants (oldPassword, newPassword) !');
        }

        try {
            $userAuth = Auth::getTokenData();
            $ldap = new User($userAuth['dn'], $params['oldPassword']);
            $user = $ldap->getUserById($userAuth['uid']);

            if ($user) {
                if (self::checkEqual($user, $userAuth)) {
                    $status = $ldap->updatePassword($user['dn'], $params['newPassword']);
                    if ($status) {
                        $auth = new Auth($user['uid'], $params['newPassword']);
                        $token = $auth->generateToken();

                        if ($token) {
                            Api::success(201, [
                                'token' => $token,
                                'user' => $user
                            ]);
                        } else {
                            Api::error(401, 'Erreur lors de la génération du token');
                        }
                    } else {
                        Api::error(500, 'Erreur lors de la mise à jour du mot de passe');
                    }
                } else {
                    Api::error(403, 'Vous n\'êtes pas autorisé à modifier cet utilisateur');
                }
            } else {
                Api::error(404, 'L\'utilisateur n\'a pas été trouvé');
            }
        } catch (\Exception $e) {
            Api::error(500, $e->getMessage());
        }
    }

    private static function checkEqual($userA, $userB)
    {
        $result = true;

        unset($userA['memberOf']);
        unset($userB['memberOf']);

        foreach ($userA as $key => $value) {
            if ($userA[$key] != $userB[$key]) {
                $result = false;
            }
        }

        return $result;
    }
}
