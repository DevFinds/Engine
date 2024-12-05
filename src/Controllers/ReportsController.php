<?php


namespace Source\Controllers;

use Core\Controller\Controller;

class ReportsController extends Controller
{
    public function index()
    {
        $this->render('/admin/dashboard/reports');
    }
}