<?php

namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\ReportService;
use Source\Services\EmployeeService;
use Source\Services\ProductService;
use Source\Services\ServiceService;
use Source\Services\ExcelExporter;
use Source\Services\LogService;

class ReportsController extends Controller
{
    public function index()
    {
        $employeeService = new EmployeeService($this->getDatabase());
        $productService = new ProductService($this->getDatabase());
        $serviceService = new ServiceService($this->getDatabase());

        $employees = $employeeService->getAllFromDB();
        $products = $productService->getAllFromDBAllSuppliers();
        $services = $serviceService->getAllFromDBAsArray();

        $this->render('/admin/dashboard/reports', [
            'employees' => $employees,
            'products' => $products,
            'services' => $services,
            'productReports' => [],
            'reports' => [],
            'reportType' => 'product',
            'selectedId' => '',
            'selectedStartDate' => '',
            'selectedEndDate' => '',
        ]);
    }

    public function getReport()
    {
        $reportType = $_POST['report_type'] ?? 'product';
        $selectedId = $reportType === 'service' ? ($_POST['service_id'] ?? '') : ($_POST['product_id'] ?? '');
        $selectedStartDate = $_POST['start_date'] ?? '';
        $selectedEndDate = $_POST['end_date'] ?? '';

        $filters = [
            'product_id' => $reportType === 'product' ? $selectedId : null,
            'service_id' => $reportType === 'service' ? $selectedId : null,
            'start_date' => $selectedStartDate,
            'end_date' => $selectedEndDate,
        ];

        $reportService = new ReportService($this->getDatabase());
        $reports = $reportType === 'service'
            ? $reportService->generateServiceReport($filters)
            : $reportService->generateProductReport($filters);

        $formattedReports = array_map(function ($r) use ($reportType) {
            if ($reportType === 'service') {
                return [
                    'name' => htmlspecialchars($r->serviceName()),
                    'car_brand' => htmlspecialchars($r->carBrand()),
                    'car_number' => htmlspecialchars($r->carNumber()),
                    'sale_date' => htmlspecialchars($r->saleDate()),
                    'payment_method' => htmlspecialchars($r->paymentMethod()),
                    'total' => number_format($r->total(), 2),
                ];
            }
            return [
                'product_name' => htmlspecialchars($r->productName()),
                'quantity' => $r->quantity(),
                'price' => number_format($r->price(), 2),
                'total' => number_format($r->total(), 2),
                'employee_name' => htmlspecialchars($r->employeeName()),
                'sale_date' => htmlspecialchars($r->saleDate()),
            ];
        }, $reports);

        $employeeService = new EmployeeService($this->getDatabase());
        $productService = new ProductService($this->getDatabase());
        $serviceService = new ServiceService($this->getDatabase());

        $employees = $employeeService->getAllFromDB();
        $products = $productService->getAllFromDBAllSuppliers();
        $services = $serviceService->getAllFromDBAsArray();

        $this->render('/admin/dashboard/reports', [
            'employees' => $employees,
            'products' => $products,
            'services' => $services,
            'productReports' => $reportType === 'product' ? $formattedReports : [],
            'reports' => $formattedReports,
            'reportType' => $reportType,
            'selectedId' => $selectedId,
            'selectedStartDate' => $selectedStartDate,
            'selectedEndDate' => $selectedEndDate,
        ]);
    }

    public function getLastActions()
    {
        $logService = new LogService($this->getDatabase());
        return  $logService->getLastActions();
    }

    public function exportReport()
    {
        try {
            $reportType = $_POST['report_type'] ?? 'product';
            $filters = [
                'product_id' => $reportType === 'product' ? ($_POST['product_id'] ?? null) : null,
                'service_id' => $reportType === 'service' ? ($_POST['service_id'] ?? null) : null,
                'start_date' => $_POST['start_date'] ?? null,
                'end_date' => $_POST['end_date'] ?? null,
            ];

            $reportService = new ReportService($this->getDatabase());
            $reports = $reportType === 'service'
                ? $reportService->generateServiceReport($filters)
                : $reportService->generateProductReport($filters);

            $rows = array_map(function ($r) use ($reportType) {
                if ($reportType === 'service') {
                    return [
                        'name' => $r->serviceName(),
                        'car_brand' => $r->carBrand(),
                        'car_number' => $r->carNumber(),
                        'sale_date' => $r->saleDate(),
                        'payment_method' => $r->paymentMethod(),
                        'total' => $r->total(),
                    ];
                }
                return [
                    'product_name' => $r->productName(),
                    'quantity' => $r->quantity(),
                    'price' => $r->price(),
                    'total' => $r->total(),
                    'employee_name' => $r->employeeName(),
                    'sale_date' => $r->saleDate(),
                ];
            }, $reports);

            $columns = $reportType === 'service' ? [
                ['header' => 'Услуга', 'key' => 'name', 'format' => 'string'],
                ['header' => 'Марка машины', 'key' => 'car_brand', 'format' => 'string'],
                ['header' => 'Номер', 'key' => 'car_number', 'format' => 'string'],
                ['header' => 'Дата', 'key' => 'sale_date', 'format' => 'string'],
                ['header' => 'Тип оплаты', 'key' => 'payment_method', 'format' => 'string'],
                ['header' => 'Сумма', 'key' => 'total', 'format' => 'number', 'number_format' => '#,##0.00'],
            ] : [
                ['header' => 'Товар', 'key' => 'product_name', 'format' => 'string'],
                ['header' => 'Кол-во', 'key' => 'quantity', 'format' => 'number', 'number_format' => '0'],
                ['header' => 'Цена', 'key' => 'price', 'format' => 'number', 'number_format' => '#,##0.00'],
                ['header' => 'Сумма', 'key' => 'total', 'format' => 'number', 'number_format' => '#,##0.00'],
                ['header' => 'Сотрудник', 'key' => 'employee_name', 'format' => 'string'],
                ['header' => 'Дата', 'key' => 'sale_date', 'format' => 'string'],
            ];

            $exporter = new ExcelExporter(
                $reportType . '_report_' . date('Y-m-d_H-i-s'),
                $columns,
                $rows
            );
            $exporter->export();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $this->redirect('404');
        }
    }
}
