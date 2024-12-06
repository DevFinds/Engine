<?php


namespace Source\Models;
class Transaction
{
	public function __construct(
        private $id,
        private $transaction_type_id,
        private $operation_type_id,
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

    public function transaction_type_id(): int
    {
        return $this->transaction_type_id;
    }

    public function operation_type_id(): int
    {
        return $this->operation_type_id;
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