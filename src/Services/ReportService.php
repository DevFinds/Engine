<?php

namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\ProductReport;
use Source\Models\ServiceReport;

class ReportService
{
    public function __construct(private DatabaseInterface $db) {}

    public function generateProductReport(array $filters): array
    {
        $productId = $filters['product_id'] ?? null;
        $startDate = $filters['start_date'] ?? null;
        $endDate = $filters['end_date'] ?? null;

        $query = "
        SELECT 
            check_items.name AS product_name,
            check_items.quantity AS quantity,
            check_items.price AS price,
            check_items.total AS total,
            users.username AS employee_name,
            checks.date AS sale_date
        FROM checks
        JOIN check_items ON check_items.check_id = checks.id
        JOIN users ON checks.operator_name COLLATE utf8mb4_unicode_ci = users.username COLLATE utf8mb4_unicode_ci
        JOIN Product ON check_items.name COLLATE utf8mb4_unicode_ci = Product.name COLLATE utf8mb4_unicode_ci
        WHERE checks.report_type = 'product'
    ";

        $params = [];
        if ($productId) {
            $query .= " AND Product.id = :product_id";
            $params['product_id'] = $productId;
        }
        if ($startDate && $endDate) {
            $query .= " AND checks.date BETWEEN :start_date AND :end_date";
            $params['start_date'] = $startDate;
            $params['end_date'] = $endDate;
        }

        $query .= " ORDER BY checks.date DESC";

        try {
            $reports = $this->db->query($query, $params);
        } catch (\Exception $e) {
            error_log('SQL Error: ' . $e->getMessage());
            return [];
        }

        return array_map(function ($report) {
            return new ProductReport(
                $report['product_name'],
                $report['quantity'],
                $report['price'],
                $report['total'],
                $report['employee_name'],
                $report['sale_date']
            );
        }, $reports);
    }

    public function generateServiceReport(array $filters): array
    {
        $serviceId = $filters['service_id'] ?? null;
        $startDate = $filters['start_date'] ?? null;
        $endDate = $filters['end_date'] ?? null;

        $query = "
        SELECT 
            Service.name AS name,
            checks.car_brand AS car_brand,
            checks.car_number AS car_number,
            checks.date AS sale_date,
            CASE 
                WHEN checks.cash > 0 AND checks.card <= 0 THEN 'cash'
                WHEN checks.card > 0 AND checks.cash <= 0 THEN 'card'
                WHEN checks.cash > 0 AND checks.card > 0 THEN 'cash'
                ELSE 'unknown'
            END AS payment_method,
            check_items.total AS total
        FROM checks
        JOIN check_items ON check_items.check_id = checks.id
        JOIN Service ON check_items.name COLLATE utf8mb4_unicode_ci = Service.name COLLATE utf8mb4_unicode_ci
        WHERE checks.report_type = 'service'
    ";

        $params = [];
        if ($serviceId) {
            $query .= " AND Service.id = :service_id";
            $params['service_id'] = $serviceId;
        }
        if ($startDate && $endDate) {
            $query .= " AND checks.date BETWEEN :start_date AND :end_date";
            $params['start_date'] = $startDate;
            $params['end_date'] = $endDate;
        }

        $query .= " ORDER BY checks.date DESC";

        try {
            $reports = $this->db->query($query, $params);
            error_log('Service report query executed. Rows returned: ' . count($reports));
            if (empty($reports)) {
                error_log('No data returned for service report. Query: ' . $query . ' Params: ' . json_encode($params));
            }
        } catch (\Exception $e) {
            error_log('SQL Error: ' . $e->getMessage());
            return [];
        }

        return array_map(function ($report) {
            return new ServiceReport(
                $report['name'],
                $report['car_brand'] ?? '',
                $report['car_number'] ?? '',
                $report['sale_date'],
                $report['payment_method'],
                $report['total'] ?? 0.0
            );
        }, $reports);
    }
}