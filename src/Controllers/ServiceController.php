<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\ServiceService;
use Source\Services\EmployeeService;

class ServiceController extends Controller
{
    public function index()
    {
        $serviceService = new ServiceService($this->getDatabase());
        $employeeService = new EmployeeService($this->getDatabase());
        $this->render('/admin/dashboard/service_sales', [
            'service' => $serviceService,
            'employees' => $employeeService
        ]);
    }
}
