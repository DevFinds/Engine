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
                check_items.name AS product_name,
                check_items.quantity AS quantity,
                check_items.price AS price,
                check_items.total AS total,
                users.username AS employee_name,
                checks.date AS sale_date
            FROM checks
            JOIN check_items ON checks.id = check_items.check_id
            JOIN users ON checks.operator_name = users.username
            JOIN Product ON check_items.name = Product.name
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
}