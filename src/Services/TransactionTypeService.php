<?php


namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\TransactionType;
class TransactionTypeService
{
	public function __construct(
        private DatabaseInterface $db
    ) {}

    public function getAllFromDB(): array
    {
        $transactionTypes = ($this->db->get('Transaction_Type'));
        return array_map(function ($transactionType) {
            return new TransactionType(
                $transactionType['id'],
                $transactionType['purpose']
            );
        }, $transactionTypes);
    }

    public function getTransactionTypeById(int $id): ?TransactionType
    {
        $transactionType = $this->db->first_found_in_db('TransactionType', ['id' => $id]);
        return $transactionType;
    }
}