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



    public function generateEmployeeReport(?int $employeeId = null, ?string $startDate = null, ?string $endDate = null): array
    {
        // Если даты не указаны, используем текущий месяц
        if ($startDate === null || $endDate === null) {
            $startDate = date('Y-m-01'); // Начало текущего месяца
            $endDate = date('Y-m-t');    // Конец текущего месяца
        }
    
        // Проверка корректности дат
        if (strtotime($startDate) > strtotime($endDate)) {
            $temp = $startDate;
            $startDate = $endDate;
            $endDate = $temp;
        }
    
        $query = "SELECT 
                     CONCAT(Employee.last_name, ' ', Employee.name, ' ', COALESCE(Employee.surname, '')) AS employee_name,
                     COALESCE(SUM(employee_schedule_days.hours_worked), 0) AS total_hours,
                     COALESCE(COUNT(Service_Sale.id), 0) AS total_services,
                     Employee.salary AS total_salary,
                     IF(COUNT(Service_Sale.id) > 0, COALESCE(SUM(Service_Sale.total_amount), 0) / COUNT(Service_Sale.id), 0) AS avg_service_price,
                     DATEDIFF(?, ?) + 1 AS days_in_period,
                     IF(DATEDIFF(?, ?) + 1 > 0, 
                        COALESCE(SUM(employee_schedule_days.hours_worked), 0) / (DATEDIFF(?, ?) + 1), 
                        0) AS avg_hours_per_day
                  FROM Employee
                  LEFT JOIN employee_schedule_days 
                     ON Employee.id = employee_schedule_days.employee_id
                     AND employee_schedule_days.date BETWEEN ? AND ?
                  LEFT JOIN Service_Sale 
                     ON Employee.id = Service_Sale.employee_id
                     AND DATE(Service_Sale.sale_date) BETWEEN ? AND ?
                  LEFT JOIN Service 
                     ON Service_Sale.service_id = Service.id
                  WHERE (? IS NULL OR Employee.id = ?)
                  GROUP BY Employee.id";
    
        $params = [
            $endDate, $startDate, // Для DATEDIFF (дни в периоде)
            $endDate, $startDate, // Для avg_hours_per_day
            $endDate, $startDate, // Для avg_hours_per_day
            $startDate, $endDate, // Для employee_schedule_days
            $startDate, $endDate, // Для Service_Sale
            $employeeId, $employeeId // Для фильтрации по сотруднику
        ];
    
        $result = $this->db->query($query, $params);
    
        // Отладочная информация
        if (empty($result)) {
            error_log("No data returned for employeeId: " . ($employeeId ?? 'all') . ", startDate: " . ($startDate ?? 'null') . ", endDate: " . ($endDate ?? 'null'));
        } else {
            foreach ($result as $row) {
                error_log("Employee: " . $row['employee_name'] . ", Total Hours: " . $row['total_hours'] . ", Total Services: " . $row['total_services'] . ", Avg Service Price: " . $row['avg_service_price']);
            }
        }
    
        return $result;
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
