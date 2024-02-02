<?php


namespace Core\http;

use Core\Upload\UploadedFileInterface;
use Core\Validator\Validator;

interface RequestInterface
{

    public static function createFromGlobals(): static;
    public function uri(): string;
    public function method(): string;
    public function input(string $key, $default = null);
    public function setValidator(Validator $validator);
    public function validate(array $rules): bool;
    public function errors(): array;
    public function file(string $key): ?UploadedFileInterface;
}
