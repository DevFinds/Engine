<?php

namespace Core\http\Router;

use Core\Render\RenderInterface;
use Core\http\Router\Route;
use Core\Auth\AuthInterface;
use Core\Event\EventManager;
use Core\Upload\FileManager;
use Core\http\RequestInterface;
use Core\Config\ConfigInterface;
use Core\http\RedirectInterface;
use Core\Upload\StorageInterface;
use Core\Session\SessionInterface;
use Core\Database\DatabaseInterface;
use Source\Events\LinkNavigationEvent;
use Core\Middleware\AbstractMiddleware;
use Source\Listeners\LinkNavigationListener;

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
        private FileManager $fileManager,
        private ConfigInterface $config,
        private EventManager $eventManager
    ) {
        $this->initRoutes();
    }


    public function dispatch(string $uri, string $method): void
    {
        // Подписка на события
        $this->eventManager->addListener('link.navigation', new LinkNavigationListener());

        $route = $this->findRoute($uri, $method);
        if (!$route) {
            $this->notFound();
        }

        $event = new LinkNavigationEvent();
        $this->eventManager->dispatch($event);

        // Проверка на наличие привязанных к маршруту посредников
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
            try {
                call_user_func_array([$controller, $action], $this->extractParams($uri, $route));
            } catch (\Throwable $th) {
                $this->render->page('404', ['error' => $th->getMessage()]);
            }
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
        foreach ($this->routes[$method] as $routeUri => $route) {
            if (preg_match($this->convertUriToRegex($routeUri), $uri)) {
                return $route;
            }
        }
        return false;
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


    // Новый метод для получения маршрутов из config/routes.json

    private function getRoutes(): array
    {
        $jsonPath = CONFIG_PATH . '/routes.json';
        if (!file_exists($jsonPath)) {
            return [];
        }

        $jsonContent = file_get_contents($jsonPath);
        $routes = json_decode($jsonContent, true);

        return array_map(fn($route) => new Route(
            $route['uri'],
            $route['method'],
            [$route['action']['controller'], $route['action']['method']],
            $route['middlewares'] ?? []
        ), $routes);
    }


    // В данном блоке происходит обработка регулярных выражений в маршрутах

    private function convertUriToRegex(string $uri): string
    {
        return '#^' . preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $uri) . '$#';
    }

    private function extractParams(string $uri, Route $route): array
    {
        $pattern = $this->convertUriToRegex($route->getUri());
        preg_match($pattern, $uri, $matches);
        array_shift($matches);
        return $matches;
    }
}
