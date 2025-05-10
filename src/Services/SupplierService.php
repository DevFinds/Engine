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
        error_log("SupplierService::getAllFromDB - Запрос всех контрагентов");
        $suppliers = $this->db->query('SELECT * FROM Supplier');
        error_log("SupplierService::getAllFromDB - Найдено записей: " . count($suppliers));
        
        $result = array_map(function ($supplier) {
            error_log("SupplierService::getAllFromDB - Обработка записи: " . json_encode($supplier));
            return new Supplier(
                $supplier['id'],
                $supplier['name'],
                $supplier['inn'],
                $supplier['ogrn'],
                $supplier['legal_address'],
                $supplier['actual_address'],
                $supplier['phone'],
                $supplier['email'],
                $supplier['contact_info']
            );
        }, $suppliers);
        
        error_log("SupplierService::getAllFromDB - Возвращено объектов: " . count($result));
        return $result;
    }

    public function getSupplierById(int $id): ?Supplier
    {
        error_log("SupplierService::getSupplierById - Запрос для ID: $id");
        $supplier = $this->db->first_found_in_db('Supplier', ['id' => $id]);
        error_log("SupplierService::getSupplierById - Результат: " . json_encode($supplier));
        if (!$supplier) {
            error_log("SupplierService::getSupplierById - Контрагент с ID $id не найден");
            return null;
        }
        $supplierObj = new Supplier(
            $supplier['id'],
            $supplier['name'],
            $supplier['inn'],
            $supplier['ogrn'],
            $supplier['legal_address'],
            $supplier['actual_address'],
            $supplier['phone'],
            $supplier['email'],
            $supplier['contact_info']
        );
        error_log("SupplierService::getSupplierById - Создан объект: " . json_encode([
            'id' => $supplierObj->id(),
            'name' => $supplierObj->name()
        ]));
        return $supplierObj;
    }

    public function hasRelatedProducts(int $supplierId): bool
    {
        error_log("SupplierService::hasRelatedProducts - Проверка для supplier_id: $supplierId");
        $result = $this->db->exists('Product', ['supplier_id' => $supplierId]);
        error_log("SupplierService::hasRelatedProducts - Результат: " . ($result ? 'true' : 'false'));
        return $result;
    }
}