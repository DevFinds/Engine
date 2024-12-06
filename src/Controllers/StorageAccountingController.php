<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\ProductService;

class StorageAccountingController extends Controller
{
    public function index()
    {
        $products = new ProductService($this->getDatabase());
        $this->render('/admin/dashboard/storage_accounting', ['products' => $products]);
    }
}
