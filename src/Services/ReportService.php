<?php

namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\ProductReport;

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
            ci.name          AS product_name,
            ci.quantity      AS quantity,
            ci.price         AS price,
            ci.total         AS total,
            u.username       AS employee_name,
            c.date           AS sale_date
        FROM checks AS c
        JOIN check_items AS ci 
          ON ci.check_id = c.id
        JOIN users AS u 
          ON c.operator_name COLLATE utf8mb4_unicode_ci = u.username COLLATE utf8mb4_unicode_ci
        JOIN Product AS p 
          ON ci.name COLLATE utf8mb4_unicode_ci = p.name COLLATE utf8mb4_unicode_ci
        WHERE c.report_type = 'product'
    ";

        $params = [];
        if ($filters['product_id'] ?? null) {
            $query   .= " AND p.id = :product_id";
            $params['product_id'] = $filters['product_id'];
        }
        if (($filters['start_date'] ?? null) && ($filters['end_date'] ?? null)) {
            $query   .= " AND c.date BETWEEN :start_date AND :end_date";
            $params['start_date'] = $filters['start_date'];
            $params['end_date']   = $filters['end_date'];
        }

        $query .= " ORDER BY c.date DESC";

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
}
