<?php

namespace Core\Container;

use Core\Render;
use Core\Auth\Auth;
use Core\http\Request;
use Core\Config\Config;
use Core\http\Redirect;
use Core\Upload\Storage;
use Core\RenderInterface;
use Core\Session\Session;
use Core\Database\Database;
use Core\Auth\AuthInterface;
use Core\http\Router\Router;
use Core\Validator\Validator;
use Core\http\RequestInterface;
use Core\Config\ConfigInterface;
use Core\http\RedirectInterface;
use Core\Upload\StorageInterface;
use Core\Session\SessionInterface;
use Core\Database\DatabaseInterface;
use Core\http\Router\RouterInterface;
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

    public readonly AuthInterface $auth;

    public readonly StorageInterface $storage;

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
        $this->config = new Config();
        $this->database = new Database($this->config);
        $this->auth = new Auth($this->database, $this->session, $this->config);
        $this->render = new Render($this->session, $this->auth);
        $this->storage = new Storage($this->config);
        $this->router = new Router(
            $this->render,
            $this->request,
            $this->redirect,
            $this->session,
            $this->database,
            $this->auth,
            $this->storage,
        );
    }
}
