<?php

namespace Source\Models;

class Payroll
{
    public function __construct(
        private $id,
        private $employee_id,
        private $year,
        private $month,
        private $first_half_hours,
        private $second_half_hours,
        private $total_hours,
        private $salary
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

    public function first_half_hours()
    {
        return $this->first_half_hours;
    }

    public function second_half_hours()
    {
        return $this->second_half_hours;
    }

    public function total_hours()
    {
        return $this->total_hours;
    }

    public function salary()
    {
        return $this->salary;
    }
}
