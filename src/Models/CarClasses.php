<?php

namespace Source\Models;

class CarClasses
{
    public function __construct(
        private $id,
        private $name
    ) {
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }
}