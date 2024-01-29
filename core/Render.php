<?php

namespace Core;

class Render
{

    public function page($controller)
    {

        $pagePath = APP_PATH . "/themes/Basic/pages/$controller.php";
        if (!file_exists($pagePath)) {
            throw new \Exception("Шаблон $controller не найден");
        }

        extract([
            'render' => $this
        ]);

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
}
