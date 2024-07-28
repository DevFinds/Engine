<?php

namespace Core\Config;

class Config implements ConfigInterface
{
    protected $config = [];
    protected $jsonConfig = [];

    public function __construct()
    {
        $this->loadJsonConfig();
    }

    // Метод для загрузки всех JSON конфигурационных файлов
    private function loadJsonConfig()
    {
        $configDirectory = APP_PATH . '/config';

        foreach (glob("$configDirectory/*.json") as $file) {
            $configName = basename($file, '.json');
            $this->jsonConfig[$configName] = json_decode(file_get_contents($file), true);
        }
    }

    // Старый метод для получения конфигурации из PHP файлов
    public function get(string $key, $default = null)
    {
        [$file, $key] = explode('.', $key);

        $configPath = APP_PATH . "/config/$file.php";

        if (!file_exists($configPath)) {
            return $default;
        }

        $config = require $configPath;
        return $config[$key] ?? $default;
    }

    // Новый метод для получения конфигурации из JSON файлов
    public function getJson(string $key, $default = null)
    {
        [$file, $key] = explode('.', $key);

        if (!isset($this->jsonConfig[$file])) {
            return $default;
        }

        return $this->jsonConfig[$file][$key] ?? $default;
    }

    // Метод для установки значения в JSON конфигурации
    public function setJson(string $key, $value): void
    {
        [$file, $key] = explode('.', $key);

        if (!isset($this->jsonConfig[$file])) {
            $this->jsonConfig[$file] = [];
        }

        $this->jsonConfig[$file][$key] = $value;
    }

    // Метод для сохранения изменений в JSON файл
    public function saveJson(string $file): void
    {
        if (isset($this->jsonConfig[$file])) {
            $configPath = APP_PATH . "/config/$file.json";
            file_put_contents($configPath, json_encode($this->jsonConfig[$file], JSON_PRETTY_PRINT));
        }
    }
}
