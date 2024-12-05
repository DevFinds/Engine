<?php


namespace Source\Controllers;

use Core\Controller\Controller;

class AccessManagmentsController extends Controller
{
    public function index()
    {
        $this->render('/admin/dashboard/access_managments');
    }
}