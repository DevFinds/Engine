<?php


namespace Source\Controllers;

use Core\Controller\Controller;

class ServiceController extends Controller
{
    public function index()
    {
        $this->render('/admin/dashboard/service_sales');
    }
}