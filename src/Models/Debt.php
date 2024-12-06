<?php


namespace Source\Models;
class Debt
{
	public function __construct(
        private $id,
        private $status,
        private $sum,
        private $start_date,
        private $end_date,
        private $supplier_id
    ) {
    }

    public function id()
    {
        return $this->id;
    }

    public function status()
    {
        return $this->status;
    }

    public function sum()
    {
        return $this->sum;
    }

    public function start_date()
    {
        return $this->start_date;
    }

    public function end_date()
    {
        return $this->end_date;
    }

    public function supplier_id()
    {
        return $this->supplier_id;
    }
}