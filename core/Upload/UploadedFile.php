<?php


namespace Core\Upload;

class UploadedFile implements UploadedFileInterface
{

    public function __construct(
        private readonly string $name,
        private readonly string $type,
        private readonly string $tmpName,
        private readonly string $error,
        public readonly int $size
    ) {}

    public function move(string $path, string $FileName = null): string | false
    {
        $storagePath = APP_PATH . "/storage/$path";

        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        $FileName = $FileName ?? $this->generated_file_name();

        $filePath = "$storagePath/$FileName";

        if (move_uploaded_file($this->tmpName, $filePath)) {
            return "$path/$FileName";
        }

        return false;
    }

    public function getFileExtension(): string
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }

    private function generated_file_name(): string
    {
        return 'image_' . md5(date('h-i-s')) . '.' . $this->getFileExtension();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getError(): int | null
    {
        return $this->error;
    }
}
