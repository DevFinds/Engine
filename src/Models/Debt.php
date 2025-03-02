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
        private $company_id,
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

/*************  ✨ Codeium Command ⭐  *************/
    /**
     * Get the sum associated with this debt.
     *
     * @return float The sum value.
     */

/******  9a3c5fec-562e-4892-9cf4-068a2a3dec46  *******/
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
        return $this->company_id;
    }
}