<?php

namespace Source\Models;

class EmployeeScheduleDay
{
    public function __construct(
        private $id,
        private $employee_schedule_id,
        private $date,
        private $status,
        private $hours_worked
    ) {
    }

    public function id()
    {
        return $this->id;
    }

    public function employee_schedule_id()
    {
        return $this->employee_schedule_id;
    }

    public function date()
    {
        return $this->date;
    }

    public function status()
    {
        return $this->status;
    }

    public function hours_worked()
    {
        return $this->hours_worked;
    }
}
