<?php


namespace Source\Models;
class EmployeeReport {
    public function __construct(
        private int $id,
        private string $fullName,
        private ?string $position,
        private ?string $scheduleName,
        private string $status,
        private ?string $hireDate,
        private ?float $salary,
        private float $totalHoursWorked,
        private int $totalServices
    ) {}

    public function id() { return $this->id; }
    public function fullName() { return $this->fullName; }
    public function position() { return $this->position; }
    public function scheduleName() { return $this->scheduleName; }
    public function status() { return $this->status; }
    public function hireDate() { return $this->hireDate; }
    public function salary() { return $this->salary; }
    public function totalHoursWorked() { return $this->totalHoursWorked; }
    public function totalServices() { return $this->totalServices; }
}