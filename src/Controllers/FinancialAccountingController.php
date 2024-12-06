<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\SupplierService;

class FinancialAccountingController extends Controller
{
    public function index()
    {
        $supplierService = new SupplierService($this->getDatabase());
        $this->render('/admin/dashboard/financial_accounting', ['suppliers' => $supplierService]);
    }
}