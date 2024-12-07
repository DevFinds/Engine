<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\SupplierService;
use Source\Services\EmployeeService;
use Source\Services\TransactionService;
use Source\Services\TransactionTypeService;
use Source\Services\CashRegisterService;
use Source\Services\DebtService;
use Source\Services\OperationTypeService;

class FinancialAccountingController extends Controller
{
    public function index()
    {
        $supplierService = new SupplierService($this->getDatabase());
        $employeeService = new EmployeeService($this->getDatabase());
        $transactionService = new TransactionService($this->getDatabase());
        $transactionTypeService = new TransactionTypeService($this->getDatabase());
        $cashRegisterService = new CashRegisterService($this->getDatabase());
        $debtService = new DebtService($this->getDatabase());
        $operationTypeService = new OperationTypeService($this->getDatabase());
        $this->render('/admin/dashboard/financial_accounting', [
            'suppliers' => $supplierService,
            'employees' => $employeeService,
            'transactions' => $transactionService,
            'transactionTypes' => $transactionTypeService,
            'cashRegisters' => $cashRegisterService,
            'debts' => $debtService,
            'operationTypes' => $operationTypeService
        ]);
    }
}