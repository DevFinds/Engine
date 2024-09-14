<?php

namespace Core\Upload;

interface StorageInterface
{
    public function get(string $path): string;
    public function urlToFile(string $url): string;
}
