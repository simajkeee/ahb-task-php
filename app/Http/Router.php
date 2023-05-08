<?php

namespace App\Http;

use App\Constants\HttpMethods;

class Router
{
    const POST_METHOD = HttpMethods::POST;
    const GET_METHOD  = HttpMethods::GET;

    private array $routes = [];

    public function get(string $uri, string|callable $handler)
    {
        $this->addRoute(self::GET_METHOD, $uri, $handler);
    }

    public function post(string $uri, string|callable $handler)
    {
        $this->addRoute(self::POST_METHOD, $uri, $handler);
    }

    public function match(string $method, string $uri)
    {
        $route = $this->findRoute($method, $uri);
        if ($route === null) {
            throw new \Exception("Page not found", 404);
        }

        return $this->executeHandler($route['handler']);
    }

    private function addRoute(string $method, string $uri, string|callable $handler)
    {
        array_unshift($this->routes, [
            'method'  => $method,
            'uri'     => $uri,
            'handler' => $handler
        ]);
    }

    private function findRoute(string $method, string $uri)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchesUri($route['uri'], $uri)) {
                return $route;
            }
        }

        return null;
    }

    private function matchesUri(string $pattern, string $uri): bool
    {
        $pattern = '#^' . str_replace(['*', '/'], ['\w+', '\/'], $pattern) . '(\?.*)?$#';
        return (bool) preg_match($pattern, $uri);
    }

    private function executeHandler(string|callable $handler)
    {
        if ($handler instanceof \Closure) {
            return $handler();
        } elseif (is_string($handler) && str_contains($handler, '@') !== false) {
            list($class, $method) = explode('@', $handler);
            $instance = new $class();
            return $instance->$method();
        } else {
            throw new \Exception("Invalid route handler");
        }
    }
}