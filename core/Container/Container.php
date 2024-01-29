<?php

namespace Core\Container;

use Core\http\Request;
use Core\http\Router\Router;
use Core\Render;
use Core\Validator\Validator;

class Container
{


    public readonly Request $request;

    public readonly Router $router;

    public readonly Render $render;

    public readonly Validator $validator;

    public function __construct()
    {
        $this->registerServices();
    }

    private function registerServices()
    {
        $this->request = Request::createFromGlobals();
        $this->render = new Render();
        $this->router = new Router($this->render, $this->request);
        $this->validator = new Validator();
        $this->request->setValidator($this->validator);
    }
}
