<?php

namespace Source\Models;

class Service
{
    public function __construct(
        private $id,
        private $name,
        private $description,
        private $price,
        private $category
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

    public function description()
    {
        return $this->description;
    }

    public function price()
    {
        return $this->price;
    }

    public function category()
    {
        return $this->category;
    }
}
