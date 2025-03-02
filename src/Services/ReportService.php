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

    public function generateProductReport(array $filters): array
    {
        $query = "SELECT 
            p.id, 
            p.name AS product_name, 
            p.unit_measurement, 
            p.purchase_price, 
            p.sale_price, 
            p.amount AS stock_amount, 
            s.name AS supplier_name, 
            w.name AS warehouse_name, 
            COALESCE(SUM(ci.quantity), 0) AS total_sold, 
            COALESCE(SUM(ci.total), 0) AS total_revenue
        FROM Product p
        LEFT JOIN Supplier s ON p.supplier_id = s.id
        LEFT JOIN Warehouse w ON p.warehouse_id = w.id
        LEFT JOIN check_items ci ON ci.name = p.name
        LEFT JOIN checks ch ON ci.check_id = ch.id AND ch.report_type = 'product'";
        
        $params = [];
        if (!empty($filters['warehouse_id'])) {
            $query .= " WHERE p.warehouse_id = :warehouse_id";
            $params['warehouse_id'] = $filters['warehouse_id'];
        }
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query .= " AND ch.date BETWEEN :start_date AND :end_date";
            $params['start_date'] = $filters['start_date'];
            $params['end_date'] = $filters['end_date'];
        }
        $query .= " GROUP BY p.id, p.name, p.unit_measurement, p.purchase_price, p.sale_price, p.amount, s.name, w.name";
        
        $results = $this->db->query($query, $params);
        return array_map(fn($row) => new ProductReport(
            $row['id'],
            $row['product_name'],
            $row['unit_measurement'],
            $row['purchase_price'],
            $row['sale_price'],
            $row['stock_amount'],
            $row['supplier_name'],
            $row['warehouse_name'],
            $row['total_sold'],
            $row['total_revenue']
        ), $results);
    }
}