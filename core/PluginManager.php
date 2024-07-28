<?php


namespace Core;

class PluginManager
{
    private array $plugins = [];

    public function __construct(private string $pluginDirectory)
    {
        $this->loadPlugins();
    }

    private function loadPlugins(): void
    {
        // Загрузка плагинов из директории
        $pluginFolders = glob($this->pluginDirectory . '/*', GLOB_ONLYDIR);
        foreach ($pluginFolders as $folder) {
            $configFile = $folder . '/plugin.json';
            if (file_exists($configFile)) {
                $config = json_decode(file_get_contents($configFile), true);
                if ($config && isset($config['class'])) {
                    $this->plugins[] = new $config['class']();
                }
            }
        }
    }

    public function initializePlugins(): void
    {
        foreach ($this->plugins as $plugin) {
            $plugin->initialize();
        }
    }
}
