<?php

namespace App\Controllers;

use App\Middlewares\Auth;
use \App\Models\File;

class HomeController
{
    public static function home() {
        if (Auth::isConnected()) {
            require_once File::page('home-connected');
        } else {
            require_once File::page('home');
        }
        
    }
}

