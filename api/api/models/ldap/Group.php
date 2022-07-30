<?php

namespace Api\Models\Ldap;

use Api\Models\Ldap\Ldap;

class Group extends Unit
{
    private $objectClass;

    public function __construct(string $username, string $password)
    {
        parent::__construct(
            $username, 
            $password, 
            [
                'cn'
            ]
        );

        $this->objectClass = ['top', 'groupOfNames'];
    }

    public function getAllGroups(): array
    {
        $groups = parent::getLdap()->search($_ENV['LDAP_GROUPS_BASE'], '(cn=*)', $this->unitAttributes);
        $groups = $this->entriesToArray($groups);
        return $groups;
    }

    public function getGroupById(string $gid): array
    {
        $group = parent::getLdap()->search($_ENV['LDAP_GROUPS_BASE'], '(cn=' . $gid . ')', $this->unitAttributes);
        $group = $this->entriesToArray($group);
        return $group[0] ?? null;
    }

    public function getGroupByDn($dn): array
    {
        $group = parent::getLdap()->search($dn, '(cn=*)', $this->unitAttributes);
        $group = $this->entriesToArray($group);
        return $group[0] ?? null;
    }

    public function createGroup(string $gid, array $members = []): array
    {
        $membersDN = [];
        foreach ($members as $member) {
            $membersDN[] = 'uid='. $member. ','. $_ENV['LDAP_USERS_BASE'];
        }

        parent::getLdap()->add('cn=' . $gid . ',' . $_ENV['LDAP_GROUPS_BASE'], [
            'objectClass' => $this->objectClass,
            'cn' => $gid,
            'member' => $membersDN,
        ]);

        return $this->getGroupById($gid);
    }

    public function updateGroup(string $dn, array $members): bool
    {
        $membersDN = [];
        foreach ($members as $member) {
            $membersDN[] = 'uid='. $member. ','. $_ENV['LDAP_USERS_BASE'];
        }

        return parent::getLdap()->modify($dn, [
            'member' => $membersDN
        ]);
    }

    public function deleteGroup(string $dn): bool
    {
        return parent::getLdap()->delete($dn);
    }

    public function getGroupsNameByUser(string $dn): array
    {
        $groups = parent::getLdap()->search($_ENV['LDAP_GROUPS_BASE'], '(member=' . $dn . ')', ['cn']);
        $array = [];
        
        for ($i = 0; $i < $groups["count"]; $i++) {
            $array[$i] = $groups[$i]['cn'][0];
        }

        return $array;
    }
    
    protected function entriesToArray(array $entries): array
    {
        $result = parent::entriesToArray($entries);
        
        $user = new User($this->username, $this->password);

        foreach ($result as $key => $group) {
            $result[$key]['member'] = $user->getUserUidByGroupDn($group['dn']);
        }

        return $result;
    }
}
