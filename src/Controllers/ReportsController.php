<?php

namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\ReportService;
use Source\Services\EmployeeService;
use Source\Services\ProductService;
use Source\Services\ServiceService;
use Source\Services\ExcelExporter;

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
        ]);
    }

    public function getReport()
    {
        $reportType = $_POST['report_type'] ?? 'product';
        $selectedProductId = $_POST['product_id'] ?? '';
        $selectedServiceId = $_POST['service_id'] ?? '';
        $selectedStartDate = $_POST['start_date'] ?? '';
        $selectedEndDate = $_POST['end_date'] ?? '';

        $filters = [
            'product_id' => $selectedProductId,
            'service_id' => $selectedServiceId,
            'start_date' => $selectedStartDate,
            'end_date' => $selectedEndDate,
        ];

        $reportService = new ReportService($this->getDatabase());
        $reports = $reportType === 'service'
            ? $reportService->generateServiceReport($filters)
            : $reportService->generateProductReport($filters);

        $formattedReports = array_map(function ($r) use ($reportType) {
            return [
                'name' => $reportType === 'service' ? htmlspecialchars($r->serviceName()) : htmlspecialchars($r->productName()),
                'quantity' => $reportType === 'service' ? 1 : $r->quantity(),
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
            'productReports' => $formattedReports,
            'reportType' => $reportType,
            'selectedProductId' => $selectedProductId,
            'selectedServiceId' => $selectedServiceId,
            'selectedStartDate' => $selectedStartDate,
            'selectedEndDate' => $selectedEndDate,
        ]);
    }

    public function exportReport()
    {
        try {
            $reportType = $_POST['report_type'] ?? 'product';
            $filters = [
                'product_id' => $_POST['product_id'] ?? null,
                'service_id' => $_POST['service_id'] ?? null,
                'start_date' => $_POST['start_date'] ?? null,
                'end_date' => $_POST['end_date'] ?? null,
            ];

            $reportService = new ReportService($this->getDatabase());
            $reports = $reportType === 'service'
                ? $reportService->generateServiceReport($filters)
                : $reportService->generateProductReport($filters);

            $rows = array_map(function ($r) use ($reportType) {
                return [
                    'name' => $reportType === 'service' ? $r->serviceName() : $r->productName(),
                    'quantity' => $reportType === 'service' ? 1 : $r->quantity(),
                    'price' => $r->price(),
                    'total' => $r->total(),
                    'employee_name' => $r->employeeName(),
                    'sale_date' => $r->saleDate(),
                ];
            }, $reports);

            $columns = [
                ['header' => $reportType === 'service' ? 'Услуга' : 'Товар', 'key' => 'name', 'format' => 'string'],
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