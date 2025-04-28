<?php

namespace Core\Render;

use Core\Auth\AuthInterface;
use Core\Config\ConfigInterface;
use Core\Event\EventManager;
use Core\Session\SessionInterface;


class Render implements RenderInterface
{

    private $activeTheme;

    public function __construct(
        private SessionInterface $session,
        private AuthInterface $auth,
        private ConfigInterface $config,
        private EventManager $eventManager
    ) {

        $this->activeTheme = $this->config->getJson('app.theme', 'Basic');
    }

    public function page($path, array $data = [])
    {
        // Передадим активную тему для системы в данную переменную
        $pagePath = APP_PATH . "/themes/$this->activeTheme/pages/$path.php";
        if (!file_exists($pagePath)) {
            $pagePath = APP_PATH . "/themes/Basic/pages/$path.php";
            if (!file_exists($pagePath)) {
                throw new \Exception("Шаблон $path не найден");
            }
        }

        extract(array_merge($this->defaultData(), $data));

        include_once $pagePath;
    }

    public function component($component_name)
    {

        $componentPath = APP_PATH . "/themes/$this->activeTheme/components/$component_name.php";
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
        $scripts = array_diff(scandir(APP_PATH . "/public/assets/themes/$this->activeTheme/js"), array('..', '.'));
        foreach ($scripts as $script) {
            echo "<script src='/assets/themes/$this->activeTheme/js/$script'></script>";
        }
    }

    public function enqueue_selected_styles(array $styles_list = [])
    {
        // Передадим активную тему для системы в данную переменную
        $styles = array_diff(scandir(APP_PATH . "/public/assets/themes/$this->activeTheme/css"), array('..', '.'));
        foreach ($styles_list as $style) {
            if (in_array($style, $styles)) {
                echo "<link rel='stylesheet' href='/assets/themes/$this->activeTheme/css/$style'>";
            }
        }
    }

    public function enqueue_selected_scripts(array $scripts_list = [])
    {
        // Передадим активную тему для системы в данную переменную
        $scripts = array_diff(scandir(APP_PATH . "/public/assets/themes/$this->activeTheme/js"), array('..', '.'));
        foreach ($scripts_list as $script) {
            if (in_array($script, $scripts)) {
                echo "<script src='/assets/themes/$this->activeTheme/js/$script'></script>";
            }
        }
    }

    public function enqueue_all_styles()
    {
        // Передадим активную тему для системы в данную переменную
        $styles = array_diff(scandir(APP_PATH . "/public/assets/themes/$this->activeTheme/css"), array('..', '.'));
        foreach ($styles as $style) {
            echo "<link rel='stylesheet' href='/assets/themes/$this->activeTheme/css/$style'>";
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

    public function enqueue_menu(string $menu_name)
    {
        $menu_layout_path = APP_PATH . "/themes/$this->activeTheme/components/menus/$menu_name.php";
        $menu_json_path = APP_PATH . "/themes/$this->activeTheme/components/menus/$menu_name.json";
        // Валидация имени меню
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $menu_name)) {
            throw new \Exception("Недопустимое имя меню.");
        }

        // Проверяем существование файлов
        if (!file_exists($menu_json_path)) {
            throw new \Exception("Файл меню '{$menu_json_path}' не найден.");
        }

        if (!file_exists($menu_layout_path)) {
            throw new \Exception("Файл шаблона меню '{$menu_layout_path}' не найден.");
        }

        // Загружаем и декодируем JSON данные меню
        $menu_json = file_get_contents($menu_json_path);
        $menu_data = json_decode($menu_json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Ошибка декодирования JSON: " . json_last_error_msg());
        }

        // Передаем данные меню в шаблон
        $menu_items = $menu_data['items'] ?? [];
        $menu_name = $menu_data['name'] ?? 'Menu';

        // Подключаем шаблон меню
        include $menu_layout_path;
        renderMenuItems($menu_items, $current_route, $this->defaultData());
    }

    public function renderMenuItems(array $items, $current_url) {}

    private function defaultData(): array
    {
        return [
            'render' => $this,
            'session' => $this->session,
            'auth' => $this->auth,
            'eventManager' => $this->eventManager
        ];
    }
}
