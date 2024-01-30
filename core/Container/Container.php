<?php

namespace Core\Container;

use Core\Config\ConfigInterface;
use Core\Config\Config;
use Core\Database\Database;
use Core\Database\DatabaseInterface;
use Core\http\Redirect;
use Core\http\RedirectInterface;
use Core\http\Request;
use Core\http\RequestInterface;
use Core\http\Router\Router;
use Core\http\Router\RouterInterface;
use Core\Render;
use Core\RenderInterface;
use Core\Session\Session;
use Core\Session\SessionInterface;
use Core\Validator\Validator;
use Core\Validator\ValidatorInterface;

class Container
{


    public readonly RequestInterface $request;

    public readonly RouterInterface $router;

    public readonly RenderInterface $render;

    public readonly ValidatorInterface $validator;

    public readonly RedirectInterface $redirect;

    public readonly SessionInterface $session;

    public readonly ConfigInterface $config;

    public readonly DatabaseInterface $database;

    public function __construct()
    {
        $this->registerServices();
    }

    private function registerServices()
    {

        $this->request = Request::createFromGlobals();
        $this->redirect = new Redirect();
        $this->validator = new Validator();
        $this->session = new Session();
        $this->request->setValidator($this->validator);
        $this->render = new Render($this->session);
        $this->router = new Router($this->render, $this->request, $this->redirect, $this->session);
        $this->config = new Config();
        $this->database = new Database($this->config);
    }
}
