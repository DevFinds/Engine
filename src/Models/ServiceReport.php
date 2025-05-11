<?php

namespace Source\Models;

class ServiceReport
{
    private string $serviceName;
    private int $quantity;
    private float $price;
    private float $total;
    private string $employeeName;
    private string $saleDate;

    public function __construct(
        string $serviceName,
        int $quantity,
        float $price,
        float $total,
        string $employeeName,
        string $saleDate
    ) {
        $this->serviceName = $serviceName;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->total = $total;
        $this->employeeName = $employeeName;
        $this->saleDate = $saleDate;
    }

    public function serviceName(): string
    {
        return $this->serviceName;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function total(): float
    {
        return $this->total;
    }

    public function employeeName(): string
    {
        return $this->employeeName;
    }

    public function saleDate(): string
    {
        return $this->saleDate;
    }
}