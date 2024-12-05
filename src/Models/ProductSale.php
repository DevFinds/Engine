<?php

namespace Source\Models;

class ProductSale
{
    public function __construct(
        private $id,
        private $sale_date,
        private $client_id,
        private $employee_id,
        private $total_amount,
        private $payment_method,
        private $service_id,
        private $warehouse_id,
        private $status,
        private $product_id
    ) {
    }

    public function id()
    {
        return $this->id;
    }

    public function sale_date()
    {
        return $this->sale_date;
    }

    public function client_id()
    {
        return $this->client_id;
    }

    public function employee_id()
    {
        return $this->employee_id;
    }

    public function total_amount()
    {
        return $this->total_amount;
    }

    public function payment_method()
    {
        return $this->payment_method;
    }

    public function service_id()
    {
        return $this->service_id;
    }

    public function warehouse_id()
    {
        return $this->warehouse_id;
    }

    public function status()
    {
        return $this->status;
    }

    public function product_id()
    {
        return $this->product_id;
    }
}
