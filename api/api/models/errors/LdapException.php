<?php

namespace Api\Models\Errors;

class LdapException extends MyException
{
    public function __construct($ldapConn, string $message, int $code = 0)
    {
        $code = ($code == 0) ? ldap_errno($ldapConn) : $code;
        http_response_code($code);
        
        parent::__construct($message, $code);

        $this->fullError = [
            'error' => $this->getMessage(),
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'ldapMsg' => [
                'error' => ldap_error($ldapConn),
                'errno' => ldap_errno($ldapConn)
            ]
        ];
    }

    public function __toString(): string
    {
        return json_encode($this->fullError);
    }
}
