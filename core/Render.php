<?php

namespace Core;

use Core\Session\SessionInterface;

class Render implements RenderInterface
{

    public function __construct(
        private SessionInterface $session
    ) {
    }

    public function page($controller)
    {

        $pagePath = APP_PATH . "/themes/Basic/pages/$controller.php";
        if (!file_exists($pagePath)) {
            throw new \Exception("Шаблон $controller не найден");
        }

        extract($this->defaultData());

        include_once $pagePath;
    }

    public function component($component_name)
    {
        $componentPath = APP_PATH . "/themes/Basic/components/$component_name.php";
        if (!file_exists($componentPath)) {
            echo "Компонент $component_name не найден";
            return;
        }

        include_once $componentPath;
    }

    private function defaultData(): array
    {
        return [
            'render' => $this,
            'session' => $this->session,
        ];
    }
}
