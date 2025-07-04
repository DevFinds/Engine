<?php

namespace Source\Models;

class Client
{
    public function __construct(
        private $id,
        private $name,
        private $email,
        private $phone,
        private $company_id
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

    public function email()
    {
        return $this->email;
    }

    public function phone()
    {
        return $this->phone;
    }

}
