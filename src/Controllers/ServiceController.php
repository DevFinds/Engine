<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\ServiceService;
use Source\Services\EmployeeService;
use Source\Services\ProductService;
use Source\Services\WarehouseService;

class ServiceController extends Controller
{
    public function index()
    {
        $serviceService = new ServiceService($this->getDatabase());
        $employeeService = new EmployeeService($this->getDatabase());
        $product_service = new ProductService($this->getDatabase());
        $warehouse_service = new WarehouseService($this->getDatabase());
        $this->render('/admin/dashboard/service_sales', [
            'service' => $serviceService,
            'employees' => $employeeService,
            'products' => $product_service,
            'warehouses' => $warehouse_service
        ]);
    }
}
