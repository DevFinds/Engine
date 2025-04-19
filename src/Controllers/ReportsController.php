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
       

        $this->render('/admin/dashboard/reports', [
            'employees' => $employees,
            
        ]);
    }

}