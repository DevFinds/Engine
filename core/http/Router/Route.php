<?php

namespace Core\http\Router;

class Route
{

    // Объявляем приватные переменные, которые будем использовать внутри методов класса




    public function __construct(
        private string $uri,
        private string $method,
        private $action
    ) {
    }

    public static function get(string $uri, $action): static
    {
        return new static($uri, 'GET', $action);
    }

    public static function post(string $uri, $action): static
    {
        return new static($uri, 'POST', $action);
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getAction(): callable
    {
        return $this->action;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}
