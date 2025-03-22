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
        $employeeReports = $employeeService->generateEmployeeReport();
        var_dump($employeeReports);
        $this->render('/admin/dashboard/reports', [
            'employees' => $employees,
            'employeeReports' => $employeeReports
        ]);
    }
}