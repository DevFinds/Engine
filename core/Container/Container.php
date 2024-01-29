<?php

namespace Core\Container;

use Core\http\Request;
use Core\http\Router\Router;
use Core\Render;

class Container
{


    public readonly Request $request;

    public readonly Router $router;

    public readonly Render $render;

    public function __construct()
    {
        $this->registerServices();
    }

    private function registerServices()
    {
        $this->request = Request::createFromGlobals();
        $this->render = new Render;
        $this->router = new Router();
    }
}
