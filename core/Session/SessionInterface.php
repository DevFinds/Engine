<?php


namespace Core\Session;

interface SessionInterface
{
    public function set(string $key, $value);
    public function get(string $key, $default = null);
    public function has(string $key): bool;
    public function remove(string $key);
    public function getFlash(string $key, $default = null);
    public function destroy();
}
