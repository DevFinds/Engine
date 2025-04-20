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
        } catch (\Exception $e) {
            $this->redirect('404');
        }
    }

    public function exportReport()
    {
        // Получаем фильтры из POST
        $productId = $_POST['product_id'] ?? '';
        $startDate = $_POST['start_date'] ?? '';
        $endDate   = $_POST['end_date'] ?? '';
        

        // Генерируем данные точно так же, как для AJAX
        $reportService = new ReportService($this->getDatabase());
        $filters = [
            'product_id' => $productId ?: null,
            'start_date' => $startDate ?: null,
            'end_date'   => $endDate   ?: null,
        ];
        $productReports = $reportService->generateProductReport($filters);

        // Колонки для ExcelExporter
        $columns = [
            ['header' => 'Наименование', 'key' => 'product_name', 'format' => 'string'],
            ['header' => 'Кол-во',       'key' => 'quantity',     'format' => 'number', 'number_format' => '0'],
            ['header' => 'Цена',         'key' => 'price',        'format' => 'number', 'number_format' => '#,##0.00'],
            ['header' => 'Сумма',        'key' => 'total',        'format' => 'number', 'number_format' => '#,##0.00'],
            ['header' => 'Сотрудник',    'key' => 'employee_name', 'format' => 'string'],
            ['header' => 'Дата',         'key' => 'sale_date',    'format' => 'string'],
        ];

        // Данные — приводим объекты или ассоц. массивы к нужному формату
        $data = array_map(function ($r) {
            return [
                'product_name'  => $r['product_name'],
                'quantity'      => $r['quantity'],
                'price'         => $r['price'],
                'total'         => $r['total'],
                'employee_name' => $r['employee_name'],
                'sale_date'     => $r['sale_date'],
            ];
        }, $productReports);

        // Формируем имя файла
        $parts = [];
        if ($productId) {
            $parts[] = "product_$productId";
        } else {
            $parts[] = "all_products";
        }
        if ($startDate && $endDate) {
            $parts[] = "{$startDate}–{$endDate}";
        } else {
            $parts[] = date('Y-m-d');
        }
        $filename = 'Финансовый отчет (' . implode(', ', $parts) . ')';
        // Выгружаем Excel
        $exporter = new ExcelExporter($filename, $columns, $data);
        $exporter->export();
    }
}
