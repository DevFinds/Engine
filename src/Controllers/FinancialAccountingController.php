<?php


namespace Source\Controllers;

use Core\Controller\Controller;

class FinancialAccountingController extends Controller
{
    public function index()
    {
        $this->render('/admin/dashboard/financial_accounting');
    }
}