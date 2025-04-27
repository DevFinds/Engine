<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\CompanyService;
use Source\Services\CompanyTypeService;
use Source\Services\EmployeeService;
use Source\Services\SupplierService;

class ManageCompanyController extends Controller
{
    public function index()
    {
        $companies = new CompanyService($this->getDatabase());
        $company_types = new CompanyTypeService($this->getDatabase());
        $employees_service = new EmployeeService($this->getDatabase());
        $suppliers = new SupplierService($this->getDatabase());
        
        $this->render('/admin/dashboard/company_managments', [
            'companies' => $companies, 
            'company_types' => $company_types,
            'employees_service' => $employees_service,
            'suppliers' => $suppliers
         ]);
    }
}
