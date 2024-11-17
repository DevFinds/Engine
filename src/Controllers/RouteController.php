<?php


namespace Source\Controllers;

use Core\http\Request;
use Core\http\Response;
use Core\http\Router\Route;
use Core\Controller\Controller;
use Core\http\Router\RouteManager;

class RouteController extends Controller
{
    private $routeManager;

    public function index()
    {
        $this->routeManager = new RouteManager(APP_PATH . '/config/routes.json');
        $this->render('/admin/dashboard/settings/route-manager', ['routes' => $this->getRoutes()]);
    }

    public function getRoutes()
    {
        $routes = $this->routeManager->loadRoutes();
        return $routes;
        // return new Response(json_encode($this->routeManager->getRoutes()), 200, ['Content-Type' => 'application/json']);
    }

    public function saveRoute(Request $request, int $index)
    {
        $data = $request->AllInputs();
        $this->routeManager->updateRoute($index, $data);
        $this->routeManager->saveRoutes();

        return new Response(json_encode(['status' => 'success']), 200, ['Content-Type' => 'application/json']);
    }

    public function deleteRoute(int $index)
    {
        $this->routeManager->deleteRoute($index);
        $this->routeManager->saveRoutes();

        return new Response(json_encode(['status' => 'success']), 200, ['Content-Type' => 'application/json']);
    }

    public function addRoute(Request $request)
    {
        $data = $request->AllInputs();
        $route = new Route(
            $data['uri'],
            $data['method'],
            $data['action'],
            $data['middlewares'] ?? [],
            $data['regular'] ?? []
        );
        $this->routeManager->addRoute($route);
        $this->routeManager->saveRoutes();

        return new Response(json_encode(['status' => 'success']), 200, ['Content-Type' => 'application/json']);
    }
}
