<?php

session_start();
require 'vendor/autoload.php';


/** *************************
 * AFFICHAGE DES ERREURS
 */
ini_set('display_errors', 1);


/** *************************
 * ENVIRONNEMENT
 */
require 'env.php';


/** *************************
 * ROUTES
 */
require 'route.php';
