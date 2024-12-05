<?php


namespace Source\Models;
class Employee
{
    public function __construct(
        private int $id,
        private string $last_name,
        private string $name,
        private string $surname,
        private string $position,
        private string $work_schedule,
        private string $status,
        private string $hire_date,
        private string $phone,
        private string $email,
        private string $hourly_rate,
        private string $salary,
        private string $notes,
        private string $organization_id
    ) {}

    public function id(): int
    {
        return $this->id;
    }

    public function last_name(): string
    {
        return $this->last_name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function surname(): string
    {
        return $this->surname;
    }

    public function position(): string
    {
        return $this->position;
    }

    public function work_schedule(): string
    {
        return $this->work_schedule;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function hire_date(): string
    {
        return $this->hire_date;
    }

    public function phone(): string
    {
        return $this->phone;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function hourly_rate(): string
    {
        return $this->hourly_rate;
    }

    public function salary(): string
    {
        return $this->salary;
    }

    public function notes(): string
    {
        return $this->notes;
    }

    public function organization_id(): string
    {
        return $this->organization_id;
    }
    
}