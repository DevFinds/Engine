<?php

namespace Source\Models;

class ProductReport {
    public function __construct(
        private string $productName,
        private int $quantity,
        private float $price,
        private float $card,
        private float $cash,
        private float $total,
        private string $employeeName,
        private string $saleDate
    ) {}

    public function productName() { return $this->productName; }
    public function quantity() { return $this->quantity; }
    public function price() { return $this->price; }
    public function cash() { return $this->cash; }
    public function card() { return $this->card; }
    public function total() { return $this->total; }
    public function employeeName() { return $this->employeeName; }
    public function saleDate() { return $this->saleDate; }
}