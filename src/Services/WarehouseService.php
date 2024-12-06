<?php


namespace Source\Services;

use Source\Models\Warehouse;
use Core\Database\DatabaseInterface;

class WarehouseService
{
    public function __construct(
        private DatabaseInterface $database
    ) {}

    public function getAllFromDB()
    {
        return $this->database->get('Warehouse');
        $warehouses = array_map(fn($warehouse) =>
        new Warehouse(
            $warehouse['id'],
            $warehouse['name'],
            $warehouse['organization_id'],
            $warehouse['location']
        ), $warehouses);
        return $warehouses;
    }
}
