<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\ServiceService;
use Source\Services\ProductService;
use Source\Services\WarehouseService;
use Source\Services\UserService;

class ServiceController extends Controller
{
    public function index()
    {
        $serviceService = new ServiceService($this->getDatabase());
        $userService = new UserService($this->getDatabase());
        $product_service = new ProductService($this->getDatabase());
        $warehouse_service = new WarehouseService($this->getDatabase());
        $this->render('/admin/dashboard/service_sales', [
            'service' => $serviceService,
            'users' => $userService,
            'products' => $product_service,
            'warehouses' => $warehouse_service
        ]);
    }
}
