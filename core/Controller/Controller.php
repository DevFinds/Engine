<?php

namespace Core\Controller;

use Core\Auth\Auth;
use Core\Upload\StorageInterface;
use Core\RenderInterface;
use Core\Auth\AuthInterface;
use Core\http\RequestInterface;
use Core\http\RedirectInterface;
use Core\Session\SessionInterface;
use Core\Database\DatabaseInterface;

abstract class Controller
{
    private RequestInterface $request;
    private RenderInterface $render;
    private RedirectInterface $redirect;
    private SessionInterface $session;
    private DatabaseInterface $database;
    private AuthInterface $auth;
    private StorageInterface $storage;


    public function render(string $page_name, array $data = []): void
    {
        $this->render->page($page_name, $data);
    }


    // Гетеры и сетеры для внедрения сервисов в контроллеры фреймворка
    // Данный блок посвящен внедрению сервисов, код другого назначения будет находиться выше

    public function setAuth(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function getAuth(): Auth
    {
        return $this->auth;
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

    /**
     * Get the value of database
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * Set the value of database
     *
     * @return  self
     */
    public function setDatabase($database)
    {
        $this->database = $database;

        return $this;
    }

    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function getStorage(): StorageInterface
    {
        return $this->storage;
    }
}
