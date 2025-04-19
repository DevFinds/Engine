<?php

namespace Source\Models;

class Employee
{
    public function __construct(
        private $id,
        private $last_name,
        private $name,
        private $surname,
        private $position,
        private $work_schedule_id,
        private $status,
        private $hire_date,
        private $phone,
        private $email,
        private $hourly_rate,
        private $salary,
        private $notes,
        private $organization_id,
        private $user_id
    ) {
    }

    public function id()
    {
        return $this->id;
    }

    public function last_name()
    {
        return $this->last_name;
    }

    public function name()
    {
        return $this->name;
    }

    public function surname()
    {
        return $this->surname;
    }

    public function position()
    {
        return $this->position;
    }

    public function work_schedule_id()
    {
        return $this->work_schedule_id;
    }

    public function status()
    {
        return $this->status;
    }

    public function hire_date()
    {
        return $this->hire_date;
    }

    public function phone()
    {
        return $this->phone;
    }

    public function email()
    {
        return $this->email;
    }

    public function hourly_rate()
    {
        return $this->hourly_rate;
    }

    public function salary()
    {
        return $this->salary;
    }

    public function notes()
    {
        return $this->notes;
    }

    public function organization_id()
    {
        return $this->organization_id;
    }

    public function user_id()
    {
        return $this->user_id;
    }
}
