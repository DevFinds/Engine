<?php


namespace Source\Controllers;

use Core\Controller\Controller;

class GoodsAndServicesController extends Controller
{
    public function index()
    {
        $this->render('/admin/dashboard/goods_and_services');
    }
}