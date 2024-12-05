<?php


namespace Core\Middleware;

use Core\Auth\AuthInterface;
use Core\http\RedirectInterface;
use Core\http\RequestInterface;
use Core\http\Router\Route;

abstract class AbstractMiddleware
{
    public function __construct(
        protected RequestInterface $request,
        protected AuthInterface $auth,
        protected RedirectInterface $redirect,
        protected Route $route
    ) {}

    abstract public function handle(): void;
}
