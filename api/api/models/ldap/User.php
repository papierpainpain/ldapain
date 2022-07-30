<?php

namespace Api\Models\Ldap;

use Api\Models\Ldap\Group;

class User extends Unit
{
    private $objectClass;

    public function __construct(string $username, string $password)
    {
        parent::__construct(
            $username,
            $password,
            [
                'uid',
                'sn',
                'cn',
                'mail'
            ]
        );

        $this->objectClass = ['top', 'person', 'inetOrgPerson'];
    }

    public function getAllUsers(): array
    {
        $users = parent::getLdap()->search($_ENV['LDAP_USERS_BASE'], '(uid=*)', $this->unitAttributes);
        $users = $this->entriesToArray($users);
        return $users;
    }

    public function getUserById(string $uid): ?array
    {
        $user = parent::getLdap()->search($_ENV['LDAP_USERS_BASE'], '(uid=' . $uid . ')', $this->unitAttributes);
        $user = $this->entriesToArray($user);
        return $user[0] ?? null;
    }

    public function getUserUidByDn(string $dn): ?string
    {
        $user = parent::getLdap()->search($dn, '(cn=*)', ['uid']);
        return $user[0]['uid'][0] ?? null;
    }

    public function getUserUidByGroupDn(string $dn): array
    {
        $group = parent::getLdap()->search($dn, '(cn=*)', ['member']);

        $groupMembers = $group[0]['member'];

        $users = [];
        for ($i = 0; $i < $groupMembers['count']; $i++) {
            $users[] = $this->getUserUidByDn($groupMembers[$i]);
        }

        return $users;
    }

    public function createUser(string $uid, string $sn, string $cn, string $mail, string $password): array
    {
        parent::getLdap()->add('uid=' . $uid . ',' . $_ENV['LDAP_USERS_BASE'], [
            'objectClass' => $this->objectClass,
            'cn' => $cn,
            'sn' => $sn,
            'userpassword' => $password,
            'mail' => $mail,
            'uid' => $uid
        ]);

        return $this->getUserById($uid);
    }

    public function updateUser(string $dn, string $firstname, string $lastname, string $mail, string $password = null): bool
    {
        $ldap = parent::getLdap();

        if ($password) {
            $user = $ldap->modify($dn, [
                'sn' => $firstname,
                'cn' => $lastname,
                'mail' => $mail,
                'userpassword' => $password
            ]);
        } else {
            $user = $ldap->modify($dn, [
                'sn' => $firstname,
                'cn' => $lastname,
                'mail' => $mail
            ]);
        }

        return $user;
    }

    public function resetPassword(string $dn, string $password): bool
    {
        $ldap = parent::getLdap();

        return $ldap->modify($dn, [
            'userpassword' => $password
        ]);
    }

    public function updatePassword(string $dn, string $password): bool
    {
        $ldap = parent::getLdap();

        return $ldap->modify($dn, [
            'userpassword' => $password
        ]);
    }

    public function deleteUser(string $dn): bool
    {
        return parent::getLdap()->delete($dn);
    }

    protected function entriesToArray(array $entries): array
    {
        $result = parent::entriesToArray($entries);
        $group = new Group($this->username, $this->password);

        foreach ($result as $key => $user) {
            $result[$key]['memberOf'] = $group->getGroupsNameByUser($user["dn"]);
        }

        return $result;
    }
}
