<?php

namespace Source\Models;

class Product
{
    public function __construct(
        private $id,
        private $name,
        private $unit_measurement,
        private $purchase_price,
        private $sale_price,
        private $supplier_id,
        private $warehouse_id,
        private $created_at,
        private $description,
        private $amount) {
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function unit_measurement()
    {
        return $this->unit_measurement;
    }

    public function purchase_price()
    {
        return $this->purchase_price;
    }

    public function sale_price()
    {
        return $this->sale_price;
    }

    public function supplier_id()
    {
        return $this->supplier_id;
    }

    public function warehouse_id()
    {
        return $this->warehouse_id;
    }

    public function created_at()
    {
        return $this->created_at;
    }

    public function description()
    {
        return $this->description;
    }

    public function amount()
    {
        return $this->amount;
    }
}