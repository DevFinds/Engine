<?php


namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\Employee;

class EmployeeService
{
    public function __construct(
        private DatabaseInterface $db
    ) {}
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
        $query = "SELECT CONCAT(Employee.last_name, ' ', Employee.name, ' ', COALESCE(Employee.surname, '')) AS employee_name,
                         SUM(employee_schedule_days.hours_worked) AS total_hours,
                         COUNT(Service_Sale.id) AS total_services,
                         SUM(Service.price) AS total_salary
                  FROM Employee
                  LEFT JOIN employee_schedule_days ON Employee.id = employee_schedule_days.id
                  LEFT JOIN Service_Sale ON Employee.id = Service_Sale.employee_id
                  LEFT JOIN Service ON Service_Sale.service_id = Service.id
                  GROUP BY Employee.id";
        return $this->db->query($query);
    }

    /**
     * Возвращает все записи из таблицы Employee в виде массива.
     *
     * @return array Массив записей из таблицы Employee.
     */
    public function getAllEmployeesRaw(): array
    {
        $query = "SELECT * FROM Employee";
        return $this->db->query($query);
    }
}
