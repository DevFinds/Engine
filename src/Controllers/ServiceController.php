<?php

namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\CarClassesService;
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
        $carClassesService = new CarClassesService($this->getDatabase());


        $this->render('/admin/dashboard/service_sales', [
            'service' => $serviceService,
            'users' => $userService,
            'products' => $product_service,
            'warehouses' => $warehouse_service,
            'cars' => $serviceService->getAllCarsAsArray(),
            'car_classes' => $serviceService->getAllClassesAsArray(),
            'car_classes_service' => $carClassesService
        ]);
    }

    public function autocompleteCars()
    {
        $query = $this->request()->input('q', '');
        $serviceService = new ServiceService($this->getDatabase());
        $cars = $serviceService->getAllCarsAsArray();

        // Фильтруем машины по state_number
        $filteredCars = array_filter($cars, function ($car) use ($query) {
            return stripos($car['state_number'], $query) !== false;
        });

        // Форматируем ответ для Select2
        $response = array_map(function ($car) {
            return [
                'id' => $car['state_number'],
                'state_number' => $car['state_number'],
                'car_brand' => $car['car_brand'],
                'class_id' => $car['class_id'],
                'client_id' => $car['client_id'],
            ];
        }, $filteredCars);

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
