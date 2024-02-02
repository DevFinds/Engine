<?php


namespace Core\Middleware;

interface MiddlewareInterface
{
    public function check(array $middlewares = []): void;
}
