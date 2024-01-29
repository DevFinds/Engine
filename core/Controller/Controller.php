<?php

namespace Core\Controller;

use Core\Render;

abstract class Controller
{

    private Render $render;

    public function render(string $page_name): void
    {
        $this->setRender();
        $this->render->page($page_name);
    }

    private function setRender(): void
    {
        $this->render = new Render();
    }
}
