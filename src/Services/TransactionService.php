<?php


namespace Source\Services;
use Core\Database\DatabaseInterface;
use Source\Models\Transaction;

class TransactionService
{
	public function __construct(
        private DatabaseInterface $db
    ) {}

    public function getAllFromDB() {
        $transactions = $this->db->get('Transaction');
        return array_map(function ($transaction) {
            return new Transaction(
                $transaction['id'],
                $transaction['transaction_type_id'],
                $transaction['operation_type_id'],
                $transaction['addresser'],
                $transaction['addressee'],
                $transaction['sum'],
                $transaction['date']
            );
        }, $transactions);
    }
}