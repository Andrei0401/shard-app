<?php

namespace App\Routes;

class Route
{
    public static function get($url, $controllerAndMethod)
    {
        return self::runRequest($url, $controllerAndMethod, 'GET');
    }

    public static function notAllowed()
    {
        header("HTTP/1.0 405 Method Not Allowed");
        exit;
    }

    protected static function runRequest($url, $controllerAndMethod, $method)
    {
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            return;
        }

        $pattern = '/^' . preg_replace('/{.+?}/i', '(.+?)', str_replace('/', '\/', trim($url, '/'))) . '$/i';

        if (!preg_match($pattern, trim($_SERVER['REQUEST_URI'], '/'), $matches)) {
            return;
        }

        self::runControllerMethod($controllerAndMethod, array_slice($matches, 1));

        exit();
    }

    protected static function runControllerMethod($controllerAndMethod, array $methodParams = [])
    {
        $tmpArray         = explode('@', $controllerAndMethod);
        $controllerClass  = array_shift($tmpArray);
        $controllerMethod = array_shift($tmpArray);

        if (!class_exists($controllerClass)) {
            throw new \Exception('Controller '.$controllerClass.' not found');
        }

        $controller = new $controllerClass;

        if (!method_exists($controller, $controllerMethod)) {
            throw new \Exception('Controller method '.$controllerMethod.' not found');
        }

        return $controller->{$controllerMethod}(...$methodParams);
    }
}