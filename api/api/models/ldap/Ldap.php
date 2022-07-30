<?php

namespace Api\Models\Ldap;

use Api\Models\Errors\LdapException;
use Api\Models\Errors\MyException;

class Ldap
{
     private $connection;

     /**
      * Constructor
      * 
      * @param null|string $login ldap dn
      * @param null|string $pwd ldap password
      * 
      * @return void
      */
     public function __construct(string $login, string $pwd)
     {
          $this->connection = $this->connect($_ENV['LDAP_HOST'], $_ENV['LDAP_PORT'], $login, $pwd);
     }

     /**
      * Connection to ldap server
      * 
      * @param string $server LDAP server name
      * @param string $port LDAP server port
      * @param string $login LDAP dn
      * @param string $pwd LDAP password
      * 
      * @return resource|false ldap connection 
      */
     private function connect(string $server, string $port, string $login, string $pwd)
     {
          $conn = ldap_connect($server, $port);
          ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
          ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);
          ldap_set_option($conn, LDAP_OPT_NETWORK_TIMEOUT, 10); 

          if (!$conn) {
               throw new MyException('Impossible de se connecter au serveur LDAP', 500);
          }

          if (!$login || !$pwd) {
               throw new MyException('Login ou mot de passe non définis', 412);
          }

          if (!ldap_bind($conn, $login, $pwd)) {
               throw new LdapException($conn, 'Identifiant ou mot de passe invalide(s)', 523);
          }

          return $conn;
     }

     /**
      * Search LDAP tree
      * 
      * @param string $base The base cn
      * @param null|string $filter The search filter
      * 
      * @return array|false
      * A complete result information in a multi-dimensional
      * array on success and FALSE on error.
      */
     public function search(string $base, ?string $filter = '(cn=*)', ?array $attributes = ['*'])
     {
          $result = ldap_search($this->connection, $base, $filter, $attributes, 0);

          if (!$result) {
               throw new LdapException($this->connection, 'Erreur lors de la recherche', 523);
          }

          $entries = ldap_get_entries($this->connection, $result);
          if (!$entries) {
               throw new LdapException($this->connection, 'Aucun résultat', 523);
          }

          return $entries;
     }

     /**
      * Modify a LDAP dn
      * 
      * @param string $dn The dn to modify
      * @param array $entry Informations to modify
      * 
      * @return bool<b>
      */
     public function modify(string $dn, array $entry)
     {
          $result = true;
          if (!ldap_modify($this->connection, $dn, $entry)) {
               $result = false;
               throw new LdapException($this->connection, 'Erreur de modification', 500);
          }
          return $result;
     }

     public function add(string $dn, array $entry)
     {
          $result = true;
          if (!ldap_add($this->connection, $dn, $entry)) {
               $result = false;
               throw new LdapException($this->connection, 'Erreur d\'ajout', 500);
          }
          return $result;
     }

     public function delete(string $dn)
     {
          $result = true;
          if (!ldap_delete($this->connection, $dn)) {
               $result = false;
               throw new LdapException($this->connection, 'Erreur de suppression', 500);
          }
          return $result;
     }

     public function close()
     {
          ldap_close($this->connection);
     }
}
