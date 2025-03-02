<?php


namespace Source\Models;
class ServiceReport {
    public function __construct(
        private int $id,
        private string $serviceName,
        private ?string $description,
        private float $price,
        private ?string $category,
        private ?string $carNumber,
        private ?string $carBrand,
        private string $saleDate,
        private float $total,
        private ?string $employeeName,
        private ?string $clientName
    ) {}
    public function id() { return $this->id; }
    public function serviceName() { return $this->serviceName; }
    public function description() { return $this->description; }
    public function price() { return $this->price; }
    public function category() { return $this->category; }
    public function carNumber() { return $this->carNumber; }
    public function carBrand() { return $this->carBrand; }
    public function saleDate() { return $this->saleDate; }
    public function total() { return $this->total; }
    public function employeeName() { return $this->employeeName; }
    public function clientName() { return $this->clientName; }
}