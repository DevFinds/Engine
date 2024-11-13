<?php

namespace Core\Upload;

class FileManager
{
    private Storage $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function upload(UploadedFile $file, string $directory = ''): string|false
    {
        return $file->move($directory);
    }

    public function deleteFile(string $path): bool
    {
        return $this->storage->delete($path);
    }

    public function listFiles(string $directory = '', int $limit = 10, int $offset = 0): array
    {
        return $this->storage->listFiles($directory, $limit, $offset);
    }

    public function getFileContent(string $path): string
    {
        return $this->storage->get($path);
    }

    public function generateFileUrl(string $path): string
    {
        return $this->storage->urlToFile($path);
    }

}
