<?php

namespace App\Models\Errors;

class LdapException extends MyException
{
    private string $ldapMsg;

    public function __construct($ldapConn, string $message, int $code = 0)
    {
        $code = ($code == 0) ? ldap_errno($ldapConn) : $code;
        http_response_code($code);
        $this->ldapMsg = ldap_error($ldapConn) . ' [' . ldap_errno($ldapConn) . ']';
        
        parent::__construct($message, $code);
        
        $this->fullError = 'ERROR [' .$this->getCode() . '] : ' .$this->getMessage() . ' (' . $this->getLdapMsg() . ')</br>' . $this->getFile() . ' (line ' . $this->getLine() . ')</br></br>';
    }

    public function __toString()
    {
        echo $this->fullError;
    }

    public function getLdapMsg() {
        return $this->ldapMsg;
    }
}
