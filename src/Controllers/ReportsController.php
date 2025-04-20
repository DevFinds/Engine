<?php

namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\EmployeeService;
use Source\Services\ExcelExporter;
use Source\Services\FinancialReportService;
use ZipArchive;

class ReportsController extends Controller
{
    public function index()
    {
        $employeeService = new EmployeeService($this->getDatabase());
        $employees = $employeeService->getAllFromDB();
        $employeeRawData = $employeeService->getAllEmployeesRaw();

        // Изначально формируем отчет без фильтров (по всем сотрудникам, без ограничения по датам)


        $this->render('/admin/dashboard/reports', [
            'employees' => $employees,

        ]);
    }

    public function generateFinancialReport()
    {
        $columns = [
            ['header' => 'Статья',      'key' => 'account', 'format' => 'string'],
            ['header' => 'Сумма, ₽',     'key' => 'amount',  'format' => 'number', 'number_format' => '#,##0'],
            ['header' => 'Себестоимость', 'key' => 'cost',    'format' => 'number', 'number_format' => '#,##0.00'],
            ['header' => 'Прибыль',      'key' => 'profit',  'format' => 'number', 'number_format' => '#,##0.00'],
            ['header' => 'Дата',         'key' => 'date',    'format' => 'string'],
            ['header' => 'Сотрудник',    'key' => 'employee', 'format' => 'string'],
            ['header' => 'Клиент',       'key' => 'client',  'format' => 'string'],
            ['header' => 'Номер авто',    'key' => 'car_number', 'format' => 'string'],
            ['header' => 'Марка авто',    'key' => 'car_brand',   'format' => 'string'],
            ['header' => 'Дата продажи',  'key' => 'sale_date',   'format' => 'string'],
            ['header' => 'Итого',         'key' => 'total',      'format' => 'number',  'number_format' => '#,##0.00'],
            ['header' => 'Имя сотрудника', 'key' => 'employee_name', 'format' => 'string'],
            ['header' => 'Имя клиента',    'key' => 'client_name',  'format' => 'string'],
        ];

        // Данные (можно получить из MySQL через PDO)
        $data = [
            ['account' => 'Продажа', 'amount' => 1000, 'cost' => 800, 'profit' => 200, 'date' => '2023-10-01', 'employee' => 'Иванов И.И.', 'client' => 'Петров П.П.', 'car_number' => 'A123BC', 'car_brand' => 'Toyota', 'sale_date' => '2023-10-01', 'total' => 1000, 'employee_name' => 'Иванов И.И.', 'client_name' => 'Петров П.П.'],
            // Добавьте больше данных по мере необходимости
            ['account' => 'Закупка', 'amount' => 500, 'cost' => 400, 'profit' => 100, 'date' => '2023-10-02', 'employee' => 'Сидоров С.С.', 'client' => 'Смирнов С.С.', 'car_number' => 'B456CD', 'car_brand' => 'Honda', 'sale_date' => '2023-10-02', 'total' => 500, 'employee_name' => 'Сидоров С.С.', 'client_name' => 'Смирнов С.С.'],
            ['account' => 'Услуга',   'amount' => 200, 'cost' => 150, 'profit' => 50, 'date' => '2023-10-03', 'employee' => 'Петров П.П.', 'client' => 'Иванов И.И.', 'car_number' => 'C789EF', 'car_brand' => 'Ford', 'sale_date' => '2023-10-03', 'total' => 200, 'employee_name' => 'Петров П.П.', 'client_name' => 'Иванов И.И.'],
            ['account' => 'Ремонт',   'amount' => 300, 'cost' => 250, 'profit' => 50, 'date' => '2023-10-04', 'employee' => 'Смирнов С.С.', 'client' => 'Сидоров С.С.', 'car_number' => 'D012GH', 'car_brand' => 'Nissan', 'sale_date' => '2023-10-04', 'total' => 300, 'employee_name' => 'Смирнов С.С.', 'client_name' => 'Сидоров С.С.'],
            ['account' => 'Запчасть', 'amount' => 150, 'cost' => 100, 'profit' => 50, 'date' => '2023-10-05', 'employee' => 'Иванов И.И.', 'client' => 'Петров П.П.', 'car_number' => 'E345IJ', 'car_brand' => 'Mazda', 'sale_date' => '2023-10-05', 'total' => 150, 'employee_name' => 'Иванов И.И.', 'client_name' => 'Петров П.П.'],
            ['account' => 'Топливо',  'amount' => 400, 'cost' => 350, 'profit' => 50, 'date' => '2023-10-06', 'employee' => 'Сидоров С.С.', 'client' => 'Смирнов С.С.', 'car_number' => 'F678JK', 'car_brand' => 'Chevrolet', 'sale_date' => '2023-10-06', 'total' => 400, 'employee_name' => 'Сидоров С.С.', 'client_name' => 'Смирнов С.С.'],
            ['account' => 'Страховка', 'amount' => 600, 'cost' => 500, 'profit' => 100, 'date' => '2023-10-07', 'employee' => 'Петров П.П.', 'client' => 'Иванов И.И.', 'car_number' => 'G901KL', 'car_brand' => 'Hyundai', 'sale_date' => '2023-10-07', 'total' => 600, 'employee_name' => 'Петров П.П.', 'client_name' => 'Иванов И.И.'],
            ['account' => 'Аренда',   'amount' => 700, 'cost' => 600, 'profit' => 100, 'date' => '2023-10-08', 'employee' => 'Смирнов С.С.', 'client' => 'Сидоров С.С.', 'car_number' => 'H234LM', 'car_brand' => 'Kia', 'sale_date' => '2023-10-08', 'total' => 700, 'employee_name' => 'Смирнов С.С.', 'client_name' => 'Сидоров С.С.'],
            ['account' => 'Обслуживание', 'amount' => 800, 'cost' => 700, 'profit' => 100, 'date' => '2023-10-09', 'employee' => 'Иванов И.И.', 'client' => 'Петров П.П.', 'car_number' => 'I567NO', 'car_brand' => 'Volkswagen', 'sale_date' => '2023-10-09', 'total' => 800, 'employee_name' => 'Иванов И.И.', 'client_name' => 'Петров П.П.'],
            ['account' => 'Технический осмотр', 'amount' => 900, 'cost' => 800, 'profit' => 100, 'date' => '2023-10-10', 'employee' => 'Сидоров С.С.', 'client' => 'Смирнов С.С.', 'car_number' => 'J890PQ', 'car_brand' => 'Subaru', 'sale_date' => '2023-10-10', 'total' => 900, 'employee_name' => 'Сидоров С.С.', 'client_name' => 'Смирнов С.С.'],
            ['account' => 'Мойка',    'amount' => 100, 'cost' => 80, 'profit' => 20, 'date' => '2023-10-11', 'employee' => 'Петров П.П.', 'client' => 'Иванов И.И.', 'car_number' => 'K123QR', 'car_brand' => 'Peugeot', 'sale_date' => '2023-10-11', 'total' => 100, 'employee_name' => 'Петров П.П.', 'client_name' => 'Иванов И.И.'],
            ['account' => 'Шиномонтаж', 'amount' => 250, 'cost' => 200, 'profit' => 50, 'date' => '2023-10-12', 'employee' => 'Сидоров С.С.', 'client' => 'Смирнов С.С.', 'car_number' => 'L456ST', 'car_brand' => 'Fiat', 'sale_date' => '2023-10-12', 'total' => 250, 'employee_name' => 'Сидоров С.С.', 'client_name' => 'Смирнов С.С.'],    
            ['account' => 'Заправка', 'amount' => 350, 'cost' => 300, 'profit' => 50, 'date' => '2023-10-13', 'employee' => 'Иванов И.И.', 'client' => 'Петров П.П.', 'car_number' => 'M789TU', 'car_brand' => 'Mazda', 'sale_date' => '2023-10-13', 'total' => 350, 'employee_name' => 'Иванов И.И.', 'client_name' => 'Петров П.П.'],
            ['account' => 'Техническое обслуживание', 'amount' => 1200, 'cost' => 1000, 'profit' => 200, 'date' => '2023-10-14', 'employee' => 'Сидоров С.С.', 'client' => 'Смирнов С.С.', 'car_number' => 'N012UV', 'car_brand' => 'Toyota', 'sale_date' => '2023-10-14', 'total' => 1200, 'employee_name' => 'Сидоров С.С.', 'client_name' => 'Смирнов С.С.'],
        ];

        $exporter = new ExcelExporter('financial_report', $columns, $data);
        if (isset($_POST['export'])) {
            $exporter->export();
        }
    }
}
