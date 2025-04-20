<?php
namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\Product;

class ProductService
{
    public function __construct(
        private DatabaseInterface $database
    ) {
    }

    public function getAllFromDB(int $warehouse_id): array
    {
        $products = $this->database->get('Product', ['warehouse_id' => $warehouse_id]);
        return array_map(fn($product) => 
            new Product(
                $product['id'],
                $product['name'],
                $product['unit_measurement'],
                $product['purchase_price'],
                $product['sale_price'],
                $product['supplier_id'],
                $product['warehouse_id'],
                $product['created_at'],
                $product['description'],
                $product['amount']
            ), $products);
    }

    public function getAllFromDBAllSuppliers(): array
    {
        $products = $this->database->get('Product');
        return array_map(fn($product) => 
            new Product(
                $product['id'],
                $product['name'],
                $product['unit_measurement'],
                $product['purchase_price'],
                $product['sale_price'],
                $product['supplier_id'],
                $product['warehouse_id'],
                $product['created_at'],
                $product['description'],
                $product['amount']
            ), $products);
    }
}