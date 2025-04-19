<?php

namespace Source\Models;

class Company
{
    public function __construct(
        private $id,
        private $name,
        private $inn,
        private $ogrn,
        private $legal_address,
        private $company_email,
        private $company_phone,
        private $company_type,
        private $kpp
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

    public function company_email()
    {
        return $this->company_email;
    }

    public function company_phone()
    {
        return $this->company_phone;
    }

    public function kpp()
    {
        return $this->kpp;
    }

    public function type()
    {
        return $this->company_type;
    }
}
