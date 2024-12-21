<?php


namespace Core\Validator;

interface ValidatorInterface
{
    public function validate(array $data, array $rules, array $labels): bool;
    public function errors(): array;
}
