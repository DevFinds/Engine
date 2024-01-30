<?php


namespace Core\http\Router;

interface RouterInterface
{

    public function dispatch(string $uri, string $method): void;
}
