<?php


namespace Core\Upload;

use Core\Config\ConfigInterface;

class Storage implements StorageInterface
{

    public function __construct(
        private ConfigInterface $config,
    ) {
    }

    public function get(string $path): string
    {
        return file_get_contents($this->storagePath($path));
    }
    public function url_to_file(string $url): string
    {
        $url_from_config = $this->config->get('app.url');
        return "$url_from_config/storage/$url";
    }

    private function storagePath(string $path): string
    {
        return APP_PATH . "/storage/$path";
    }
}
