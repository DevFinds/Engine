<?php

namespace Source\Models;

class EmployeeSchedule
{
    public function __construct(
        private $id,
        private $employee_id,
        private $year,
        private $month
    ) {
    }

    public function id()
    {
        return $this->id;
    }

    public function employee_id()
    {
        return $this->employee_id;
    }

    public function year()
    {
        return $this->year;
    }

    public function month()
    {
        return $this->month;
    }
}
