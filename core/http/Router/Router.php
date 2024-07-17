<?php

namespace Core\http\Router;

use Core\RenderInterface;
use Core\Auth\AuthInterface;
use Core\Config\ConfigInterface;
use Core\http\RequestInterface;
use Core\http\RedirectInterface;
use Core\Session\SessionInterface;
use Core\Database\DatabaseInterface;
use Core\Middleware\AbstractMiddleware;
use Core\Upload\StorageInterface;

class Router implements RouterInterface
{
    private array $routes = [

        'GET' => [],
        'POST' => [],

    ];

    public function __construct(
        private RenderInterface $render,
        private RequestInterface $request,
        private RedirectInterface $redirect,
        private SessionInterface $session,
        private DatabaseInterface $database,
        private AuthInterface $auth,
        private StorageInterface $storage,
        private ConfigInterface $config
    ) {
        $this->initRoutes();
    }

    public function dispatch(string $uri, string $method): void
    {
        $route = $this->findRoute($uri, $method);
        if (!$route) {
            $this->notFound();
        }


        // Проверка на привязанных к маршруту посредников
        if ($route->hasMiddlewares()) {
            // Если посреднеки переданы в данный маршрут
            foreach ($route->getMiddlewares() as $middleware) {
                /** 
                 * @var AbstractMiddleware $middleware 
                 * */
                // Создаем сущности этих классов
                $middleware = new $middleware($this->request, $this->auth, $this->redirect);
                // Вызываем обработчики данных классов
                $middleware->handle();
            }
        }

        if (is_array($route->getAction())) {
            // Создаем массив, в который помещаем значения из массива, возвращаемого методом getAction(), если он является таковым
            [$controller, $action] = $route->getAction();
            // В переменной $controller сейчас хранится путь до необходимого контроллера, создаем контроллер, на который указывает путь.
            $controller = new $controller();

            /** 
             * @var Controller $controller 
             */


            // Вызываем action из указанного контроллера.
            call_user_func([$controller, 'setRender'], $this->render);
            call_user_func([$controller, 'setRequest'], $this->request);
            call_user_func([$controller, 'setRedirect'], $this->redirect);
            call_user_func([$controller, 'setSession'], $this->session);
            call_user_func([$controller, 'setDatabase'], $this->database);
            call_user_func([$controller, 'setAuth'], $this->auth);
            call_user_func([$controller, 'setStorage'], $this->storage);
            call_user_func([$controller, 'setConfig'], $this->config);
            call_user_func([$controller, $action]);
        } else {
            // Или выполняем анонимную функцию, переданную в routes.php
            call_user_func($route->getAction());
        }
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
