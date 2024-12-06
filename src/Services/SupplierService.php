<?php

namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\Supplier;

class SupplierService
{
    public function __construct(
        private DatabaseInterface $db
    ) {}

   
    public function getAllFromDB(): array
    {
        $suppliers = $this->db->get('Supplier');
        return array_map(function ($supplier) {
            return new Supplier(
                $supplier['id'],
                $supplier['name'],
                $supplier['phone'],
                $supplier['email']
            );
        }, $suppliers);
    }

    
    public function getSupplierById(int $id): ?Supplier
    {
        $supplier = $this->db->first_found_in_db('Supplier', ['id' => $id]);
        return $supplier;
    }
}