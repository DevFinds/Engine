<?php


namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\OperationType;
class OperationTypeService
{
	public function __construct(
        private DatabaseInterface $db
    ) {}

    public function getAllFromDB(): array
    {
        $operationTypes = ($this->db->get('Operation_Type'));
        return array_map(function ($operationType) {
            return new OperationType(
                $operationType['id'],
                $operationType['operation']
            );
        }, $operationTypes);
    }
}