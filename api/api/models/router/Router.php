<?php

namespace Api\Models\Router;

use Api\Models\Api;
use \Api\Models\Router\Route;

/**
 *
 */
class Router
{

    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get($path, $callable, $access, $name = null)
    {
        return $this->add($path, $callable, $name, 'GET', $access);
    }

    public function post($path, $callable, $access, $name = null)
    {
        return $this->add($path, $callable, $name, 'POST', $access);
    }

    public function put($path, $callable, $access, $name = null)
    {
        return $this->add($path, $callable, $name, 'PUT', $access);
    }

    public function delete($path, $callable, $access, $name = null)
    {
        return $this->add($path, $callable, $name, 'DELETE', $access);
    }

    public function options($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'OPTIONS');
    }

    public function add(string $path, string $callable, ?string $name, string $method, ?bool $access = true)
    {
        $route = new Route($_ENV['API_BASE'] . $path, $callable, $access);
        $this->routes[$method][] = $route;
        if (is_string($callable) && $name === null) {
            $name = $callable;
        }
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            Api::send(405, 'REQUEST_METHOD does not exist');
        }

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {

            if ($route->matchUrl($this->url)) {

                if (!$route->allowMiddleware()) {
                    Api::send(403, 'Vous n\'avez pas le droit !');
                } else {
                    return $route->call();
                }
            }
        }

        Api::send(404, 'No route found for this URL');
    }
}
