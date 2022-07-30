<?php

namespace Api\Models\Ldap;

class Unit
{
    private $ldap;
    protected $unitAttributes;
    protected $username;
    protected $password;

    public function __construct(string $username, string $password, array $unitAttributes) {
        $this->username = $username;
        $this->password = $password;
        $this->ldap = new Ldap($this->username, $this->password);
        $this->unitAttributes = $unitAttributes;
    }

    protected function getLdap() {
        return $this->ldap;
    }

    public function __destruct() {
        $this->ldap->close();
    }

    /**
     * Method to convert an array of LDAP entries to an array based on the unitAttributes
     */
    protected function entriesToArray(array $entries) {
        $result = [];
        for ($i = 0; $i < $entries['count']; $i++) {
            $entry = $entries[$i];
            $result[$i]['dn'] = $entry['dn'];

            foreach ($this->unitAttributes as $field) {
                $result[$i][$field] = $entry[$field][0];
            }
        }
        return $result;
    }
}