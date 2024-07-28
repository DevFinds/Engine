<?php


namespace Core\Config;

interface ConfigInterface
{
    public function get(string $key, $default = null);
    public function getJson(string $key, $default = null);
    public function setJson(string $key, $value);
    public function saveJson(string $file);
}
