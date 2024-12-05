<?php

namespace Source\Models;

class Service
{
    public function __construct(
        private $id,
        private $name,
        private $description,
        private $price,
        private $category,
        private $car_id
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

    public function car_id()
    {
        return $this->car_id;
    }
}
