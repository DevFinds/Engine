<?php

namespace Core\http\Router;

class Router
{
    private array $routes = [

        'GET' => [],
        'POST' => [],

    ];

    public function __construct()
    {
        $this->initRoutes();
    }

    public function dispatch(string $uri, string $method): void
    {
        $route = $this->findRoute($uri, $method);
        if (!$route) {
            $this->notFound();
        }

        $route->getAction()();
    }

    private function initRoutes()
    {
        $routes_list = $this->getRoutes();
        foreach ($routes_list as $route) {
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }
    }

    private function findRoute(string $uri, string $method): Route|false
    {
        if (!isset($this->routes[$method][$uri])) {
            return false;
        }

        return $this->routes[$method][$uri];
    }

    private function notFound(): void
    {
        echo "404 | Not found";
        exit;
    }

    // С помощью PHP-docs обозначим в данном файле переменную $routes как класс
    /**
     * @return Route[]
     */


    private function getRoutes(): array
    {
        return require_once APP_PATH . '/config/routes.php';
    }
}
