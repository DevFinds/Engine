<?php

namespace Core;

use Core\http\Router\Router;

class App
{

    public function run(): void
    {

        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $router = new Router();
        $router->dispatch($uri, $method);
    }
}
