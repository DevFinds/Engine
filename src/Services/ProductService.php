<?php


namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\Product;

class ProductService
{
	public function __construct(
        private DatabaseInterface $database
    )
    {

    }

    public function getAllFromDB(int $warehouse_id): array
    {
        return $this->database->get('Product', ['warehouse_id' => $warehouse_id]);
        $products = array_map(fn($product) => 
        new Product(
            $product['id'],
            $product['name'],
            $product['category'],
            $product['unit_measurement'],
            $product['purchase_price'],
            $product['sale_price'],
            $product['supplier_id'],
            $product['warehouse_id'],
            $product['created_at'],
            $product['description'],
            $product['amount']
        ), $products);

        return $products;

    }

    public function getAllFromDBAllSuppliers(): array
    {
        return $this->database->get('Product');
        $products = array_map(fn($product) => 
        new Product(
            $product['id'],
            $product['name'],
            $product['category'],
            $product['unit_measurement'],
            $product['purchase_price'],
            $product['sale_price'],
            $product['supplier_id'],
            $product['warehouse_id'],
            $product['created_at'],
            $product['description'],
            $product['amount']
        ), $products);

        return $products;
    }
}