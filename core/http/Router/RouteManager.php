<?php


namespace Core\http\Router;

use Core\http\Router\Route;

class RouteManager
{
    private array $routes;
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->routes = $this->loadRoutes();
    }

    public function loadRoutes(): array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }

        $routesData = json_decode(file_get_contents($this->filePath), true);
        $routes = [];

        foreach ($routesData as $data) {
            $routes[] = new Route(
                $data['uri'],
                $data['method'],
                $data['action'],
                $data['middlewares'] ?? [],
                $data['regular'] ?? []
            );
        }

        return $routes;
    }

    public function saveRoutes(): void
    {
        $routesData = array_map(function (Route $route) {
            return [
                'uri' => $route->getUri(),
                'method' => $route->getMethod(),
                'action' => $route->getAction(),
                'middlewares' => $route->getMiddlewares(),
                'regular' => $route->getRegular(),
            ];
        }, $this->routes);

        file_put_contents($this->filePath, json_encode($routesData, JSON_PRETTY_PRINT));
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function updateRoute(int $index, array $data): void
    {
        if (isset($this->routes[$index])) {
            $this->routes[$index]
                ->setUri($data['uri'])
                ->setMethod($data['method'])
                ->setAction($data['action'])
                ->setMiddlewares($data['middlewares'] ?? [])
                ->setRegular($data['regular'] ?? []);
        }
    }

    public function deleteRoute(int $index): void
    {
        if (isset($this->routes[$index])) {
            array_splice($this->routes, $index, 1);
        }
    }

    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }
}
