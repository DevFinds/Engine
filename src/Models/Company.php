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
        private $actual_address,
        private $company_email,
        private $company_phone,
        private $contact_info,
        private $tax_id
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

    public function company_email()
    {
        return $this->company_email;
    }

    public function company_phone()
    {
        return $this->company_phone;
    }

    public function contact_info()
    {
        return $this->contact_info;
    }

    public function tax_id()
    {
        return $this->tax_id;
    }
}
