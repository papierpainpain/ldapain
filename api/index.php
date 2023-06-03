<?php

/*
|--------------------------------------------------------------------------
| Index
|--------------------------------------------------------------------------
|
| Description
|
*/

ini_set('display_errors', 1);

// *** API HEADERS *** //
setlocale(LC_ALL, 'fr_FR.UTF8');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Accept: application/json");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();

// *** REQUIREMENTS *** //
require 'vendor/autoload.php';

// *** ENVIRONNEMENT VARIABLES *** //

// Uncomment to use the development environment with .env file
// use \Dotenv\Dotenv;
// $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
// $dotenv->load();

$_ENV = getenv();

// *** ROUTES *** //
require 'route.php';
