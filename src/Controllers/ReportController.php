<?php


namespace Source\Controllers;

use Core\Controller\Controller;

class ReportController extends Controller
{
    public function index()
    {
        $this->render('admin/dashboard/reports');
    }
}
