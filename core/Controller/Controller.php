<?php

namespace Core\Controller;

use Core\http\Request;
use Core\Render;

abstract class Controller
{
    private Request $request;
    private Render $render;


    public function render(string $page_name): void
    {
        $this->render->page($page_name);
    }

    public function setRender(Render $render): void
    {
        $this->render = $render;
    }

    public function request(): Request
    {
        return $this->request;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
}
