<?php

namespace Source\Models;

class CashRegister
{
    public function __construct(
        private $id,
        private $cash_amount,
        private $organization_id,
        private $cash_type,
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

    public function cash_amount()
    {
        return $this->cash_amount;
    }

    public function organization_id()
    {
        return $this->organization_id;
    }

    public function cash_type()
    {
        return $this->cash_type;
    }
}
