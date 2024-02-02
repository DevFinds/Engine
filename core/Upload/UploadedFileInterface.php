<?php


namespace Core\Upload;

interface UploadedFileInterface
{
    public function move(string $path): string | false;
    public function getFileExtension(): string;
}
