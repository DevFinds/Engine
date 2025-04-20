<?php
namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\ReportService;
use Source\Services\EmployeeService;
use Source\Services\ProductService;

class ReportsController extends Controller
{
    public function index()
    {
        $employeeService = new EmployeeService($this->getDatabase());
        $productService = new ProductService($this->getDatabase());

        $employees = $employeeService->getAllFromDB();
        $products = $productService->getAllFromDBAllSuppliers();

        $this->render('/admin/dashboard/reports', [
            'employees' => $employees,
            'products' => $products,
            'productReports' => [],
        ]);
    }

    public function getReport()
    {
        try {
            $reportService = new ReportService($this->getDatabase());

            $filters = [
                'product_id' => $_POST['product_id'] ?? null,
                'start_date' => $_POST['start_date'] ?? null,
                'end_date' => $_POST['end_date'] ?? null,
            ];

            error_log('Filters: ' . print_r($filters, true));

            $productReports = $reportService->generateProductReport($filters);

            $reports = array_map(function ($report) {
                return [
                    'product_name' => htmlspecialchars($report->productName()),
                    'quantity' => $report->quantity(),
                    'price' => number_format($report->price(), 2),
                    'total' => number_format($report->total(), 2),
                    'employee_name' => htmlspecialchars($report->employeeName()),
                    'sale_date' => htmlspecialchars($report->saleDate()),
                ];
            }, $productReports);

            error_log('Reports: ' . print_r($reports, true));
            
            return json_encode($reports);
        } catch (\Exception $e) {
            error_log('Error in getReport: ' . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Ошибка сервера: ' . $e->getMessage()]);
        }
        
    }
}