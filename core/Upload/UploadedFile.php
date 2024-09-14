<?php


namespace Core\Upload;

class UploadedFile implements UploadedFileInterface
{
    private const ALLOWED_FILE_TYPES = ['image/jpeg', 'image/png', 'image/gif'];

    public function __construct(
        private readonly string $name,
        private readonly string $type,
        private readonly string $tmpName,
        private readonly string $error,
        public readonly int $size
    ) {
    }

    public function move(string $path, string $fileName = null): string|false
    {
        if (!$this->isValidType()) {
            return false; // Неверный тип файла
        }

        $storagePath = APP_PATH . "/storage/$path";

        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        $fileName = $fileName ?? $this->generateFileName();
        $filePath = "$storagePath/$fileName";

        if (move_uploaded_file($this->tmpName, $filePath)) {
            return "$path/$fileName";
        }

        return false;
    }

    public function getFileExtension(): string
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }

    private function generateFileName(): string
    {
        return 'file_' . uniqid() . '.' . $this->getFileExtension();
    }

    private function isValidType(): bool
    {
        return in_array($this->type, self::ALLOWED_FILE_TYPES);
    }
}
