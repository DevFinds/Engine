<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\CompanyService;
use Source\Services\CompanyTypeService;

class GoodsAndServicesController extends Controller
{
    public function index()
    {
        $companies = new CompanyService($this->getDatabase());
        $company_types = new CompanyTypeService($this->getDatabase());
        $this->render('/admin/dashboard/goods_and_services', ['companies' => $companies, 'company_types' => $company_types]);
    }

    public function addNewGood()
    {



        $validation = $this->request()->validate([
            'name' => ['required'],
            'amount' => ['required'],
            'created_at' => ['required'],
            'unit_measurement' => ['required'],
            'purchase_price' => ['required'],
            'sale_price' => ['required'],
            'supplier_id' => ['required'],
            'warehouse_id' => ['required'],
            'description' => ['required'],
        ]);

        if (!$validation) {


            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/admin/dashboard/goods_and_services');
            //dd('Validation failed', $this->request()->errors());
        }

        $Product = $this->getDatabase()->insert('Product', [
            'name' => $this->request()->input('name'),
            'amount' => $this->request()->input('amount'),
            'created_at' => $this->request()->input('created_at'),
            'unit_measurement' => $this->request()->input('unit_measurement'),
            'purchase_price' => $this->request()->input('purchase_price'),
            'sale_price' => $this->request()->input('sale_price'),
            'supplier_id' => $this->request()->input('supplier_id'),
            'warehouse_id' => $this->request()->input('warehouse_id'),
            'description' => $this->request()->input('description')
        ]);


        $this->redirect('/admin/dashboard/goods_and_services');
    }
}
