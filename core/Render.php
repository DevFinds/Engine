<?php

namespace Core;

use Core\Auth\AuthInterface;
use Core\Config\ConfigInterface;
use Core\Session\SessionInterface;


class Render implements RenderInterface
{

    public function __construct(
        private SessionInterface $session,
        private AuthInterface $auth,
        private ConfigInterface $config,
    ) {
    }


    public function page($controller)
    {
        // Передадим активную тему для системы в данную переменную
        $activeTheme = $this->config->get('app.theme', 'Basic');
        $pagePath = APP_PATH . "/themes/$activeTheme/pages/$controller.php";
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

        extract($this->defaultData());

        include_once $componentPath;
    }

    public function enqueue_all_scripts()
    {
        // Передадим активную тему для системы в данную переменную
        $activeTheme = $this->config->get('app.theme', 'Basic');
        $themeName = $activeTheme . 'Theme';
        $scripts = array_diff(scandir(APP_PATH . "/public/assets/themes/$themeName/js"), array('..', '.'));
        foreach ($scripts as $script) {
            echo "<script src='$script'></script>";
        }
    }

    public function enqueue_selected_styles(array $styles_list = [])
    {
        // Передадим активную тему для системы в данную переменную
        $activeTheme = $this->config->get('app.theme', 'Basic');
        $themeName = $activeTheme . 'Theme';
        $styles = array_diff(scandir(APP_PATH . "/public/assets/themes/$themeName/css"), array('..', '.'));
        foreach ($styles_list as $style) {
            if (in_array($style, $styles)) {
                echo "<link rel='stylesheet' href='$style'>";
            }
        }
    }

    public function enqueue_selected_scripts(array $scripts_list = [])
    {
        $activeTheme = $this->config->get('app.theme', 'Basic');
        $themeName = $activeTheme . 'Theme';
        $scripts = array_diff(scandir(APP_PATH . "/public/assets/themes/$themeName/js"), array('..', '.'));
        foreach ($scripts_list as $script) {
            if (in_array($script, $scripts)) {
                echo "<script src='$script'></script>";
            }
        }
    }

    public function enqueue_all_styles()
    {
        // Передадим активную тему для системы в данную переменную
        $activeTheme = $this->config->get('app.theme', 'Basic');
        $themeName = $activeTheme . 'Theme';
        $styles = array_diff(scandir(APP_PATH . "/public/assets/themes/$themeName/css"), array('..', '.'));
        foreach ($styles as $style) {
            echo "<link rel='stylesheet' href='$style'>";
        }
    }

    public function system_head()
    {
        $this->enqueue_all_styles();
    }

    public function system_footer()
    {
        $this->enqueue_all_scripts();
    }

    private function defaultData(): array
    {
        return [
            'render' => $this,
            'session' => $this->session,
            'auth' => $this->auth,
        ];
    }
}
