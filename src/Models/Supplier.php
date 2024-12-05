<?php

namespace Source\Models;

class Supplier
{
    public function __construct(
        private $id,
        private $name,
        private $phone,
        private $email
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

    public function phone()
    {
        return $this->phone;
    }

    public function email()
    {
        return $this->email;
    }
}
