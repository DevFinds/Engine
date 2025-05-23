<?php
namespace Source\Models;

class Car
{
    public function __construct(
        private $id,
        private $state_number,
        private $car_type,
        private $car_brand,
        private $client_id,
        private $car_model = null,
        private $class_id = null
    ) {
    }

    public function id()
    {
        return $this->id;
    }

    public function state_number()
    {
        return $this->state_number;
    }

    public function car_type()
    {
        return $this->car_type;
    }

    public function car_brand()
    {
        return $this->car_brand;
    }

    public function client_id()
    {
        return $this->client_id;
    }

    public function car_model()
    {
        return $this->car_model;
    }

    public function class_id()
    {
        return $this->class_id;
    }
}