<?php

namespace Core\Controller;

use Core\http\RedirectInterface;
use Core\http\RequestInterface;
use Core\RenderInterface;
use Core\Session\SessionInterface;

abstract class Controller
{
    private RequestInterface $request;
    private RenderInterface $render;
    private RedirectInterface $redirect;
    private SessionInterface $session;


    public function render(string $page_name): void
    {
        $this->render->page($page_name);
    }

    public function setRender(RenderInterface $render): void
    {
        $this->render = $render;
    }

    public function request(): RequestInterface
    {
        return $this->request;
    }

    public function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
    }

    public function setRedirect(RedirectInterface $redirect): void
    {
        $this->redirect = $redirect;
    }

    public function redirect(string $url)
    {
        $this->redirect->to($url);
    }

    public function setSession(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function session(): SessionInterface
    {
        return $this->session;
    }
}
