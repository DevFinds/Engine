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
        try {
            $query = $this->request()->input('q', '');
            if (strlen($query) < 2) {
                $this->jsonResponse([]);
                return;
            }

            $query = strtoupper($query);
            $sql = "SELECT state_number, car_brand, class_id FROM Car WHERE state_number LIKE :query";
            $cars = $this->getDatabase()->query($sql, ['query' => '%' . $query . '%']);

            error_log('Cars found for query ' . $query . ': ' . json_encode($cars, JSON_UNESCAPED_UNICODE));

            if (!$cars) {
                $this->jsonResponse([]);
                return;
            }

            $response = array_map(function ($car) {
                return [
                    'id' => $car['state_number'],
                    'text' => $car['state_number'], // Для Select2
                    'state_number' => $car['state_number'],
                    'car_brand' => $car['car_brand'] ?? '',
                    'class_id' => $car['class_id'] ? (string)$car['class_id'] : ''
                ];
            }, $cars);

            $this->jsonResponse($response);
        } catch (\Exception $e) {
            error_log('Error in autocompleteCars: ' . $e->getMessage());
            $this->jsonResponse(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    protected function jsonResponse($data, $status = 200)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($status);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}