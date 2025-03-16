<?php

namespace Source\Services;

use Source\Models\ProductReport;
use Core\Database\DatabaseInterface;

class ReportService
{
    private DatabaseInterface $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function generateProductReport(array $filters):array
    {
        $product_report = $this->db->get('product_report', $filters);
        return array_map(function ($report) {
            $return = new ProductReport(
                $report['id'],
                $report['name'],
                $report['description'],
                $report['price'],
                $report['category'],
                $report['car_number'],
                $report['car_brand'],
                $report['sale_date'],
                $report['total'],
                $report['employee_name'],
                $report['client_name']
            );
    
        }, $product_report);
    }
    
}