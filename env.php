<?php
setlocale(LC_ALL, 'fr_FR.UTF8');

define('ENV', [
    'site' => [
        'name' => 'LDAPain',
        'mail' => ''
    ],
    'ldap' => [
        'host' => '',
        'port' => '389',
        'base' => '',
        'user' => '',
        'pwd' => '',
        'users' => '',
        'admin' => ''
    ],
    'smtp' => [
        'host' => 'smtp.gmail.com',
        'port' => 465,
        'user' => '',
        'pwd' => '',
    ]
]);
