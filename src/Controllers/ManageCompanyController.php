<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\CompanyService;
use Source\Services\CompanyTypeService;

class ManageCompanyController extends Controller
{
    public function index()
    {
        $companies = new CompanyService($this->getDatabase());
        $company_types = new CompanyTypeService($this->getDatabase());
        $this->render('/admin/dashboard/company_managments', ['companies' => $companies, 'company_types' => $company_types]);
    }
}
