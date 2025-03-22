<?php


namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\Employee;

class EmployeeService
{
	public function __construct(
        private DatabaseInterface $db
    )
    {
    }
    public function getAllFromDB(): array
    {
        $employees = $this->db->get('Employee');
        return array_map(function ($employee) {
            return new Employee(
                $employee['id'],
                $employee['last_name'],
                $employee['name'],
                $employee['surname'],
                $employee['position'],
                $employee['work_schedule_id'],
                $employee['status'],
                $employee['hire_date'],
                $employee['phone'],
                $employee['email'],
                $employee['hourly_rate'],
                $employee['salary'],
                $employee['notes'],
                $employee['organization_id'],
                $employee['user_id']
            );
        }, $employees);
    }

    public function getEmployeeById(int $id): ?Employee
    {
        $employee = $this->db->first_found_in_db('Employee', ['id' => $id]);
        return $employee;
    }

    public function generateEmployeeReport(): array
    {
        $query = "SELECT e.name, SUM(es.hours_worked) as total_hours, COUNT(s.id) as total_services, SUM(s.price) as total_salary
                  FROM Employee e
                  LEFT JOIN employee_schedule_days es ON e.id = es.employee_id
                  LEFT JOIN Service s ON e.id = s.employee_id
                  GROUP BY e.id, e.name";
        return $this->db->query($query);
    }
}