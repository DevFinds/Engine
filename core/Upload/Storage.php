<?php


namespace Core\Upload;

use Core\Config\ConfigInterface;

class Storage implements StorageInterface
{
    public function __construct(
        private ConfigInterface $config,
    ) {}

    public function get(string $path): string
    {
        return file_get_contents($this->storagePath($path));
    }

    public function put(string $path, string $content): bool
    {
        return file_put_contents($this->storagePath($path), $content) !== false;
    }

    public function delete(string $path): bool
    {
        $filePath = $this->storagePath($path);
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    public function listFiles(string $directory = '', int $limit = 10, int $offset = 0): array
    {
        $dir = $this->storagePath($directory);
        if (!is_dir($dir)) {
            return [];
        }

        $files = array_slice(scandir($dir), $offset, $limit);
        return array_filter($files, fn($file) => !is_dir($file));
    }

    public function urlToFile(string $url): string
    {
        $url_from_config = $this->config->get('app.url');
        return "$url_from_config/storage/$url";
    }

    private function storagePath(string $path): string
    {
        return APP_PATH . "/storage/$path";
    }
}
