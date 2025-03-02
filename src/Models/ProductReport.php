<?php

namespace Source\Models;

class ProductReport {
    public function __construct(
        private int $id,
        private string $productName,
        private string $unitMeasurement,
        private float $purchasePrice,
        private float $salePrice,
        private int $stockAmount,
        private string $supplierName,
        private string $warehouseName,
        private int $totalSold,
        private float $totalRevenue
    ) {}

    public function id() { return $this->id; }
    public function productName() { return $this->productName; }
    public function unitMeasurement() { return $this->unitMeasurement; }
    public function purchasePrice() { return $this->purchasePrice; }
    public function salePrice() { return $this->salePrice; }
    public function stockAmount() { return $this->stockAmount; }
    public function supplierName() { return $this->supplierName; }
    public function warehouseName() { return $this->warehouseName; }
    public function totalSold() { return $this->totalSold; }
    public function totalRevenue() { return $this->totalRevenue; }
}