<?php

namespace App\Models;


/**
 * Accès aux différents type de fichiers
 * présent dans l'arborescence.
 *
 * @package Models
 */
class File
{

    public static function page($name)
    {
        return 'app/views/' . $name . '.php';
    }

    public static function views($name)
    {
        return 'app/views/' . $name;
    }

    public static function parts($name)
    {
        return 'app/views/partials/' . $name . '.php';
    }

    public static function vendor($name)
    {
        return 'vendor/' . $name;
    }

    public static function image($url)
    {
        return '/public/images/' . $url;
    }

    public static function svg($url)
    {
        return 'public/images/' . $url . '.svg';
    }

    public static function css($url)
    {
        return '/public/css/' . $url;
    }

    public static function js($url)
    {
        return '/public/js/' . $url . '.js';
    }
}
