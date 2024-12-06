<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\ServiceService;

class ServiceController extends Controller
{
    public function index()
    {
        $serviceService = new ServiceService($this->getDatabase());
        $this->render('/admin/dashboard/service_sales', ['service' => $serviceService]);
    }
}
