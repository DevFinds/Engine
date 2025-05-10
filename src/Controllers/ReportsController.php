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

    // Метод формирования и отображения отчёта
    public function getReport()
    {
        // 1) Чтение и сохранение фильтров
        $selectedProductId = $_POST['product_id']  ?? '';
        $selectedStartDate = $_POST['start_date']  ?? '';
        $selectedEndDate   = $_POST['end_date']    ?? '';

        $filters = [
            'product_id' => $selectedProductId,
            'start_date' => $selectedStartDate,
            'end_date'   => $selectedEndDate,
        ];

        // 2) Получаем сырые данные
        $reportService  = new ReportService($this->getDatabase());
        $productReports = $reportService->generateProductReport($filters);

        // 3) Преобразуем в массивы для шаблона
        $reports = array_map(function ($r) {
            return [
                'product_name'  => htmlspecialchars($r->productName()),
                'quantity'      => $r->quantity(),
                'price'         => number_format($r->price(), 2),
                'total'         => number_format($r->total(), 2),
                'employee_name' => htmlspecialchars($r->employeeName()),
                'sale_date'     => htmlspecialchars($r->saleDate()),
            ];
        }, $productReports);

        // 4) Справочники
        $employees = (new EmployeeService($this->getDatabase()))->getAllFromDB();
        $products  = (new ProductService($this->getDatabase()))->getAllFromDBAllSuppliers();

        // 5) Рендерим шаблон, передаём отчёты и фильтры
        $this->render('/admin/dashboard/reports', [
            'employees'          => $employees,
            'products'           => $products,
            'productReports'     => $reports,
            'selectedProductId'  => $selectedProductId,
            'selectedStartDate'  => $selectedStartDate,
            'selectedEndDate'    => $selectedEndDate,
        ]);
    }

    public function exportReport()
    {

        try {
            // Читаем те же фильтры
            $filters = [
                'product_id' => $_POST['product_id'] ?? null,
                'start_date' => $_POST['start_date'] ?? null,
                'end_date'   => $_POST['end_date']   ?? null,
            ];

            // Получаем данные для Excel
            $reportService  = new ReportService($this->getDatabase());
            $productReports = $reportService->generateProductReport($filters);

            $rows = array_map(function ($r) {
                return [
                    'product_name'  => $r->productName(),
                    'quantity'      => $r->quantity(),
                    'price'         => $r->price(),
                    'total'         => $r->total(),
                    'employee_name' => $r->employeeName(),
                    'sale_date'     => $r->saleDate(),
                ];
            }, $productReports);

            // Описание колонок
            $columns = [
                ['header' => 'Товар', 'key' => 'product_name', 'format' => 'string'],
                ['header' => 'Кол-во', 'key' => 'quantity', 'format' => 'number', 'number_format' => '0'],
                ['header' => 'Цена', 'key' => 'price', 'format' => 'number', 'number_format' => '#,##0.00'],
                ['header' => 'Сумма', 'key' => 'total', 'format' => 'number', 'number_format' => '#,##0.00'],
                ['header' => 'Сотрудник', 'key' => 'employee_name', 'format' => 'string'],
                ['header' => 'Дата', 'key' => 'sale_date', 'format' => 'string'],
            ];

            // Экспорт
            $exporter = new \Source\Services\ExcelExporter(
                'product_report_' . date('Y-m-d_H-i-s'),
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
