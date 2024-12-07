<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\ProductService;
use Source\Services\SupplierService;

class StorageAccountingController extends Controller
{
    public function index()
    {
        $products = new ProductService($this->getDatabase());
        $suppliers = new SupplierService($this->getDatabase());
        $this->render('/admin/dashboard/storage_accounting', [
            'products' => $products,
            'suppliers' => $suppliers
        ]);
    }
}
