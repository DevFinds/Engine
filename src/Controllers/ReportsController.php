<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\EmployeeService;

class ReportsController extends Controller
{
    public function index()
    {
        $employeeService = new EmployeeService($this->getDatabase());
        $this->render('/admin/dashboard/reports', [
            'employees' => $employeeService,
        ]);
    }
}