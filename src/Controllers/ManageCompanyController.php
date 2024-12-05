<?php


namespace Source\Controllers;

use Core\Controller\Controller;

class ManageCompanyController extends Controller
{
    public function index()
    {
        $this->render('/admin/dashboard/company_managments');
    }
}