<?php

namespace Api\Controllers;

use Api\Models\Api;
use Api\Models\Auth;


/**
 * Class TokenController
 * 
 * @package Api\Controllers
 */
class TokenController
{

    /**
     * @OA\Post(
     *      path="/token", tags={"token"},
     *      summary="Generate a token",
     *      description="Returns a token",
     *      operationId="generateToken",
     * 
     *      @OA\RequestBody(
     *          description="Generate a token",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="uid", type="string"),
     *              @OA\Property(property="password", type="string")
     *          )
     *      ),
     *      
     *      @OA\Response(response=201, description="Token created"),
     *      @OA\Response(response=400, description="Missing/Incorrect parameters"),
     *      @OA\Response(response=401, description="Failed to create token")
     * )
     */
    public static function generateToken()
    {
        $params = json_decode(file_get_contents('php://input'), true);

        if (!isset($params['uid']) || !isset($params['password'])) {
            Api::error(400, 'Paramètres manquants (uid, password)');
        }

        try {
            $authObj = new Auth($params['uid'], $params['password']);
            $token = $authObj->generateToken();

            if ($token) {
                Api::success(201, ['token' => $token]);
            } else {
                Api::error(401, 'Impossible de créer le token');
            }
        } catch (\Exception $e) {
            Api::error(401, $e->getMessage());
        }
    }
}
