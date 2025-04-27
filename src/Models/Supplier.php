<?php

namespace Source\Models;

class Supplier
{
    public function __construct(
        private $id,
        private $name,
        private $inn,
        private $ogrn,
        private $legal_address,
        private $actual_address,
        private $phone,
        private $email,
        private $contact_info
    ) {}

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function inn()
    {
        return $this->inn;
    }

    public function ogrn()
    {
        return $this->ogrn;
    }

    public function legal_address()
    {
        return $this->legal_address;
    }

    public function actual_address()
    {
        return $this->actual_address;
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
