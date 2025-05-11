<?php


namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\Debt;

class DebtService
{
    public function __construct(
        private DatabaseInterface $db
    ) {}

    public function getAllFromDB(): array
    {
        $debts = ($this->db->get('Debt'));
        return array_map(function ($debt) {
            return new Debt(
                $debt['id'],
                $debt['status'],
                $debt['sum'],
                $debt['start_date'],
                $debt['end_date'],
                $debt['supplier_id']
            );
        }, $debts);
    }
}
