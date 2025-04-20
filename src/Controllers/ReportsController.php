<?php

namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\ReportService;
use Source\Services\EmployeeService;
use Source\Services\ProductService;
use Source\Services\ExcelExporter;
use Source\Services\FinancialReportService;
use ZipArchive;

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


            $employeeService = new EmployeeService($this->getDatabase());
            $productService = new ProductService($this->getDatabase());

            $employees = $employeeService->getAllFromDB();
            $products = $productService->getAllFromDBAllSuppliers();

            $this->render('/admin/dashboard/reports', [
                'employees' => $employees,
                'products' => $products,
                'productReports' => $reports
            ]);


        } 
        catch (\Exception $e) {
            $this->redirect('404');
        }
    }
}
