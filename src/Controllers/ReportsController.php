<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\EmployeeService;
use Source\Services\ReportService;

class ReportsController extends Controller
{
    public function index()
    {
        $employeeService = new EmployeeService($this->getDatabase());
        $this->createReport();
        // $this->render('/admin/dashboard/reports', [
        //     'employees' => $employeeService,
        // ]);
        
    }

    public function createReport()
    {
        $reportType = $_POST['reportType'] ?? '';
        $filters = [
            'warehouse_id' => 2,
            'start_date' => '2023-06-01',
            'end_date' => '2023-06-30'
        ];

         
            $employeeService = new EmployeeService($this->getDatabase());
            $reportDat = $employeeService->getAllFromDB();

            $reportService = new ReportService($this->getDatabase());
            $reportData = $reportService->generateProductReport($filters);  
            

        // $this->render('/admin/dashboard/reports', [
        //     'reportData' => $reportData,
        //     'reportType' => $reportType,
        // ]);
    }
}