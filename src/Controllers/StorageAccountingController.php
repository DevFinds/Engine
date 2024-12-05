<?php


namespace Source\Controllers;

use Core\Controller\Controller;

class StorageAccountingController extends Controller
{
    public function index()
    {
        $this->render('/admin/dashboard/storage_accounting');
    }
}