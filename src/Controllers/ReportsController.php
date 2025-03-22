<?php
namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\EmployeeService;

class ReportsController extends Controller
{
    public function index()
    {
        $employeeService = new EmployeeService($this->getDatabase());
        $employees = $employeeService->getAllFromDB();
        $employeeRawData = $employeeService->getAllEmployeesRaw();

        // Изначально формируем отчет без фильтров (по всем сотрудникам, без ограничения по датам)
        $employeeReports = $employeeService->generateEmployeeReport();

        $this->render('/admin/dashboard/reports', [
            'employees' => $employees,
            'employeeRawData' => $employeeRawData,
            'employeeReports' => $employeeReports
        ]);
    }

    public function getEmployeeReport()
    {
        $employeeService = new EmployeeService($this->getDatabase());

        $employeeId = isset($_POST['employee_id']) && $_POST['employee_id'] !== 'all' ? (int)$_POST['employee_id'] : null;
        $startDate = isset($_POST['start_date']) && !empty($_POST['start_date']) ? $_POST['start_date'] : null;
        $endDate = isset($_POST['end_date']) && !empty($_POST['end_date']) ? $_POST['end_date'] : null;

        $employeeReports = $employeeService->generateEmployeeReport($employeeId, $startDate, $endDate);

       
    }
}