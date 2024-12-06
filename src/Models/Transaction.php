<?php


namespace Source\Models;
class Transaction
{
	public function __construct(
        private $id,
        private $type,
        private $addresser,
        private $addresee,
        private $sum,
        private $date
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function addresser(): string
    {
        return $this->addresser;
    }

    public function addresee(): string
    {
        return $this->addresee;
    }

    public function sum(): float
    {
        return $this->sum;
    }
}