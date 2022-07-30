<?php

namespace Api\Models\Router;

/**
 * 
 */
class Route
{

    private $path;
    private $callable;
    private $middleware;
    private $matches = [];
    private $params = [];

    public function __construct($path, $callable, bool $middleware = false)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
        $this->middleware = $middleware;
    }

    public function matchUrl($url)
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {

            return false;
        }

        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    public function allowMiddleware()
    {
        return ($this->middleware);
    }

    public function paramMatch($match)
    {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function call()
    {
        return call_user_func_array($this->callable, $this->matches);
    }
}
