<?php


namespace Source\Models;
class OperationType
{
	public function __construct(
        private $id,
        private $operation
    ) {
    }

    public function id()
    {
        return $this->id;
    }

    public function operation()
    {
        return $this->operation;
    }
}