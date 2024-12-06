<?php


namespace Source\Services;
use Core\Database\DatabaseInterface;
use Source\Models\CashRegister;
class CashRegisterService
{
	public function __construct(
        private DatabaseInterface $db
    ) {}

    public function getAllFromDB(): array
    {
        $cashRegisters = ($this->db->get('CashRegister'));
        return array_map(function ($cashRegister) {
            return new CashRegister(
                $cashRegister['id'],
                $cashRegister['cash_amount'],
                $cashRegister['organization_id'],
                $cashRegister['cash_type'],
                $cashRegister['name']
            );
        }, $cashRegisters);
    }
}