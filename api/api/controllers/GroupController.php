<?php

namespace Api\Controllers;

use Api\Models\Ldap\Group;


/**
 * Class GroupController
 * 
 * @package Api\Controllers
 */
class GroupController
{

    /**
     * @OA\Get(
     *      path="/groups", tags={"groups"},
     *      summary="Get all groups",
     *      operationId="getAllGroups",
     *      description="Returns a list of all groups",
     *      security={{"bearerAuth":{}}},
     *      
     *      @OA\Response(
     *          response=200, description="List of groups",
     *          @OA\MediaType(mediaType="application/json")
     *      ),
     *      @OA\Response(response=403, description="Access denied"),
     *      @OA\Response(response=404, description="Not found")
     * )
     */
    public static function getAllGroups()
    {
        $groupObj = new Group($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $groups = $groupObj->getAllGroups();
        if (count($groups) > 0) {
            self::send(200, $groups);
        } else {
            self::send(404, ['error' => 'Aucun groupe trouvé']);
        }
    }

    /**
     * @OA\Get(
     *      path="/groups/{gid}", tags={"groups"},
     *      summary="Get a group by gid",
     *      description="Returns a group by gid",
     *      operationId="getGroupById",
     *      security={{"bearerAuth":{}}},
     *      
     *      @OA\Parameter(
     *          name="gid", in="path", required=true,
     *          description="Gid of the group to retrieve",
     *          @OA\Schema(type="string")
     *      ),
     *      
     *      @OA\Response(
     *          response=200, description="List of groups",
     *          @OA\MediaType(mediaType="application/json")
     *      ),
     *      @OA\Response(response=403, description="Access denied"),
     *      @OA\Response(response=404, description="Not found")
     * )
     */
    public static function getGroupById($gid)
    {
        $groupObj = new Group($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $group = $groupObj->getGroupById($gid);
        if ($group) {
            self::send(200, $group);
        } else {
            self::send(404, ['error' => 'Groupe introuvable']);
        }
    }

    /**
     * @OA\Post(
     *      path="/groups", tags={"groups"},
     *      summary="Create a group",
     *      description="Create a group",
     *      operationId="createGroup",
     *      security={{"bearerAuth":{}}},
     * 
     *      @OA\RequestBody(
     *          description="Create group object",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="members", description="Members", type="array",
     *                  @OA\Items(type="string")
     *              )
     *          )
     *      ),
     *      
     *      @OA\Response(response=201, description="Group created"),
     *      @OA\Response(response=400, description="Missing/Incorrect parameters"),
     *      @OA\Response(response=403, description="Access denied"),
     *      @OA\Response(response=409, description="Group already exists"),
     *      @OA\Response(response=500, description="Failed to create user")
     * )
     */
    public static function createGroup()
    {
        $params = json_decode(file_get_contents('php://input'), true);

        // check if params are valid
        if (!isset($params['gid']) || !isset($params['members'])) {
            self::send(400, ['error' => 'Paramètres manquants (gid et members)']);
        }

        $groupObj = new Group($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $group = $groupObj->getGroupById($params['gid']);
        if ($group) {
            self::send(409, ['error' => 'Le groupe existe déjà']);
        } else {
            if ($groupObj->createGroup($params['gid'], $params['members'])) {
                self::send(201, ['success' => 'Groupe créé']);
            } else {
                self::send(500, ['error' => 'Erreur lors de la création du groupe']);
            }
        }
    }

    /**
     * @OA\Put(
     *      path="/groups/{gid}", tags={"groups"},
     *      summary="Update a group",
     *      description="Update a group",
     *      operationId="updateGroup",
     *      security={{"bearerAuth":{}}},
     *      
     *      @OA\Parameter(
     *          name="gid", in="path", required=true,
     *          description="Gid of the group to update",
     *          @OA\Schema(type="string")
     *      ),
     * 
     *      @OA\RequestBody(
     *          description="Update group object",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="members", description="Members", type="array",
     *                  @OA\Items(type="string")
     *              )
     *          )
     *      ),
     *      
     *      @OA\Response(response=200, description="Group updated"),
     *      @OA\Response(response=400, description="Missing/Incorrect parameters"),
     *      @OA\Response(response=403, description="Access denied"),
     *      @OA\Response(response=404, description="Group not found"),
     *      @OA\Response(response=500, description="Failed to update user")
     * )
     */
    public static function updateGroup($gid)
    {
        $params = json_decode(file_get_contents('php://input'), true);

        // check if params are valid
        if (!isset($params['members'])) {
            self::send(400, ['error' => 'Paramètres manquants (members)']);
        }

        $groupObj = new Group($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $group = $groupObj->getGroupById($gid);
        if ($group) {
            $group = $groupObj->updateGroup($group['dn'], $params['members']);
            if ($group) {
                self::send(200, ['success' => 'Groupe mis à jour']);
            } else {
                self::send(500, ['error' => 'Erreur lors de la mise à jour du groupe']);
            }
        } else {
            self::send(404, ['error' => 'Groupe introuvable']);
        }
    }

    /**
     * @OA\Put(
     *      path="/groups/{gid}/members", tags={"groups"},
     *      summary="Add members to a group",
     *      description="Add members to a group",
     *      operationId="addUsersToGroup",
     *      security={{"bearerAuth":{}}},
     *      
     *      @OA\Parameter(
     *          name="gid", in="path", required=true,
     *          description="Gid of the group to update",
     *          @OA\Schema(type="string")
     *      ),
     * 
     *      @OA\RequestBody(
     *          description="Add members list to group object",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="members", description="Members", type="array",
     *                  @OA\Items(type="string")
     *              )
     *          )
     *      ),
     *      
     *      @OA\Response(response=200, description="Group updated"),
     *      @OA\Response(response=400, description="Missing/Incorrect parameters"),
     *      @OA\Response(response=403, description="Access denied"),
     *      @OA\Response(response=404, description="Group not found"),
     *      @OA\Response(response=500, description="Failed to update user")
     * )
     */
    public static function addUsersToGroup(string $gid)
    {
        $params = json_decode(file_get_contents('php://input'), true);

        // check if params are valid
        if (!isset($params['members'])) {
            self::send(400, ['error' => 'Paramètres manquants (members)']);
        }

        $groupObj = new Group($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $group = $groupObj->getGroupById($gid);
        if ($group) {
            $members = $group['members'];
            foreach ($params['members'] as $member) {
                if (!in_array($member, $members)) {
                    $members[] = $member;
                }
            }
            $group = $groupObj->updateGroup($group['dn'], $members);
            if ($group) {
                self::send(200, ['success' => 'Groupe mis à jour']);
            } else {
                self::send(500, ['error' => 'Erreur lors de la mise à jour du groupe']);
            }
        } else {
            self::send(404, ['error' => 'Groupe introuvable']);
        }
    }

    /**
     * @OA\Delete(
     *      path="/groups/{gid}/members", tags={"groups"},
     *      summary="Remove members to a group",
     *      description="Remove members to a group",
     *      operationId="deleteUsersToGroup",
     *      security={{"bearerAuth":{}}},
     *      
     *      @OA\Parameter(
     *          name="gid", in="path", required=true,
     *          description="Gid of the group to update",
     *          @OA\Schema(type="string")
     *      ),
     * 
     *      @OA\RequestBody(
     *          description="Remove members list to group object",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="members", description="Members", type="array",
     *                  @OA\Items(type="string")
     *              )
     *          )
     *      ),
     *      
     *      @OA\Response(response=200, description="Group deleted"),
     *      @OA\Response(response=400, description="Missing/Incorrect parameters"),
     *      @OA\Response(response=403, description="Access denied"),
     *      @OA\Response(response=404, description="Group not found"),
     *      @OA\Response(response=500, description="User could not be deleted")
     * )
     */
    public static function deleteUsersToGroup(string $gid)
    {
        $params = json_decode(file_get_contents('php://input'), true);

        // check if params are valid
        if (!isset($params['members'])) {
            self::send(400, ['error' => 'Paramètres manquants (members)']);
        }

        $groupObj = new Group($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $group = $groupObj->getGroupById($gid);
        if ($group) {
            $members = $group['members'];
            foreach ($params['members'] as $member) {
                if (in_array($member, $members)) {
                    $key = array_search($member, $members);
                    unset($members[$key]);
                }
            }

            if ($groupObj->updateGroup($group['dn'], $members)) {
                self::send(200, ['success' => 'Groupe mis à jour']);
            } else {
                self::send(500, ['error' => 'Erreur lors de la mise à jour du groupe']);
            }
        } else {
            self::send(404, ['error' => 'Groupe introuvable']);
        }
    }

    /**
     * @OA\Delete(
     *      path="/groups/{gid}", tags={"groups"},
     *      summary="Delete a group",
     *      description="Delete a group",
     *      operationId="deleteGroup",
     *      security={{"bearerAuth":{}}},
     *      
     *      @OA\Response(response=200, description="Group deleted"),
     *      @OA\Response(response=403, description="Access denied"),
     *      @OA\Response(response=404, description="Group not found"),
     *      @OA\Response(response=500, description="Group could not be deleted")
     * )
     */
    public static function deleteGroup($gid)
    {
        $groupObj = new Group($_ENV['LDAP_ADMIN_USER'], $_ENV['LDAP_ADMIN_PASS']);
        $group = $groupObj->getGroupById($gid);
        if ($group) {
            if ($groupObj->deleteGroup($group['dn'])) {
                self::send(200, ['success' => 'Groupe supprimé']);
            } else {
                self::send(500, ['error' => 'Erreur lors de la suppression du groupe']);
            }
        } else {
            self::send(404, ['error' => 'Groupe introuvable']);
        }
    }

    private static function send($status, $data)
    {
        http_response_code($status);
        echo json_encode($data);
        exit();
    }
}
