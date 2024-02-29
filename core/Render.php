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

    public function page($path, array $data = [])
    {
        // Передадим активную тему для системы в данную переменную
        $activeTheme = $this->config->get('app.theme', 'Basic');
        $pagePath = APP_PATH . "/themes/$activeTheme/pages/$path.php";
        if (!file_exists($pagePath)) {
            throw new \Exception("Шаблон $path не найден");
        }

        extract(array_merge($this->defaultData(), $data));

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

        include $componentPath;
    }

    public function enqueue_all_scripts()
    {
        // Передадим активную тему для системы в данную переменную
        $activeTheme = $this->config->get('app.theme', 'Basic');
        $scripts = array_diff(scandir(APP_PATH . "/public/assets/themes/$activeTheme/js"), array('..', '.'));
        foreach ($scripts as $script) {
            echo "<script src='/assets/themes/$activeTheme/js/$script'></script>";
        }
    }

    public function enqueue_selected_styles(array $styles_list = [])
    {
        // Передадим активную тему для системы в данную переменную
        $activeTheme = $this->config->get('app.theme', 'Basic');
        $styles = array_diff(scandir(APP_PATH . "/public/assets/themes/$activeTheme/css"), array('..', '.'));
        foreach ($styles_list as $style) {
            if (in_array($style, $styles)) {
                echo "<link rel='stylesheet' href='$style'>";
            }
        }
    }

    public function enqueue_selected_scripts(array $scripts_list = [])
    {
        $activeTheme = $this->config->get('app.theme', 'Basic');
        $scripts = array_diff(scandir(APP_PATH . "/public/assets/themes/$activeTheme/js"), array('..', '.'));
        foreach ($scripts_list as $script) {
            if (in_array($script, $scripts)) {
                echo "<script src='/assets/themes/$activeTheme/js/$script'></script>";
            }
        }
    }

    public function enqueue_all_styles()
    {
        // Передадим активную тему для системы в данную переменную
        $activeTheme = $this->config->get('app.theme', 'Basic');
        $styles = array_diff(scandir(APP_PATH . "/public/assets/themes/$activeTheme/css"), array('..', '.'));
        foreach ($styles as $style) {
            echo "<link rel='stylesheet' href='/assets/themes/$activeTheme/css/$style'>";
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
