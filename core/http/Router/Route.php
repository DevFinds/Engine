<?php

namespace Core\http\Router;

class Route
{

    // Объявляем приватные переменные, которые будем использовать внутри методов класса

    public function __construct(
        private string $uri, // URI-адрес действия
        private string $method, // Метод вызова действия
        private $action, // Действие
        private array $middlewares = [], // Массив с промежуточными обработчиками
        private array $regular = [], // Регулярное выражение
        private int $access_level = 1
    ) {}

    // Геттеры и сеттеры для приватных переменных

    public static function get(string $uri, $action, array $middlewares = []): static
    {
        return new static($uri, 'GET', $action, $middlewares);
    }

    public static function post(string $uri, $action, array $middlewares = []): static
    {
        return new static($uri, 'POST', $action, $middlewares);
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }


    // Получение регулярного выражения
    public function getRegular(): array
    {
        return $this->regular;
    }

    public function hasMiddlewares(): bool
    {
        return !empty($this->middlewares);
    }

    public function getAccessLevel()
    {
        return $this->access_level;
    }

    public function where(array $regular): static
    {
        $this->regular = $regular;
        return $this;
    }
}
