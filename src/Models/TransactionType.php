<?php


namespace Source\Models;
class TransactionType
{
	public function __construct(
        private $id,
        private $purpose,
        private $operation
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function purpose(): string
    {
        return $this->purpose;
    }

    public function operation()
    {
        return $this->operation;
    }
}