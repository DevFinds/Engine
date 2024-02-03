<?php

namespace Core\Upload;

interface StorageInterface
{
    public function url_to_file(string $url): string;
    public function get(string $path): string;
}
