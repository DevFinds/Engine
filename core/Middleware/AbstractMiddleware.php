<?php


namespace Core\Middleware;

use Core\Auth\AuthInterface;
use Core\http\RedirectInterface;
use Core\http\RequestInterface;

abstract class AbstractMiddleware
{
    public function __construct(
        protected RequestInterface $request,
        protected AuthInterface $auth,
        protected RedirectInterface $redirect,
    ) {
    }

    abstract public function handle(): void;
}
