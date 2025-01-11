<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\CompanyService;
use Source\Services\ProductService;
use Source\Services\ServiceService;
use Source\Services\WarehouseService;
use Source\Services\CompanyTypeService;

class GoodsAndServicesController extends Controller
{

    public function index()
    {

        $company_service = new CompanyService($this->getDatabase());
        $company_type_service = new CompanyTypeService($this->getDatabase());
        $warehouse_service = new WarehouseService($this->getDatabase());
        $product_service = new ProductService($this->getDatabase());
        $service_service = new ServiceService($this->getDatabase());

        
        $field_error_event = $this->FieldErrorEventDispath('error', 'error', 'error');
        $error_array = $field_error_event->getPayload();

        $this->render('/admin/dashboard/goods_and_services', [

            'company_service' => $company_service,
            'company_type_service' => $company_type_service,
            'warehouse_service' => $warehouse_service,
            'product_service' => $product_service,
            'service_service' => $service_service
        ]);
    }

    public function addNewGood()
    {

        $labels = [
            'name' => 'Наименование',
            'amount' => 'Количество',
            'created_at' => 'Дата создания',
            'unit_measurement' => 'Ед. изм.',
            'purchase_price' => 'Цена закупки',
            'sale_price' => 'Цена продажи',
            'supplier_id' => 'Поставщик',
            'warehouse_id' => 'Склад'
        ];

        $validation = $this->request()->validate([
            'name' => ['required'],
            'amount' => ['required'],
            'created_at' => ['required'],
            'unit_measurement' => ['required'],
            'purchase_price' => ['required'],
            'sale_price' => ['required'],
            'supplier_id' => ['required'],
            'warehouse_id' => ['required']
        ], $labels);

        if (!$validation) {


            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/admin/dashboard/goods_and_services');
            dd('Проверка не пройдена', $this->request()->errors());
        }

        if ($this->getDatabase()->first_found_in_db('Product', ['name' => $this->request()->input('name')])) {
            dd('Таблица уже существует');
        } else {
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
        }




        $this->redirect('/admin/dashboard/goods_and_services');
    }

    public function addNewService()
    {
        $labels = [
            'name' => 'Наименование',
            'price' => 'Цена',
            'category' => 'Категория'
        ];

        $validation = $this->request()->validate([
            'name' => ['required'],
            'price' => ['required'],
            'category' => ['required']
        ], $labels);

        if (!$validation) {


            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/admin/dashboard/goods_and_services');
            //dd('Validation failed', $this->request()->errors());
        }

        if ($this->getDatabase()->first_found_in_db('Service', ['name' => $this->request()->input('name')])) {
            dd('Таблица уже существует');
        } else {
            $Service = $this->getDatabase()->insert('Service', [
                'name' => $this->request()->input('name'),
                'description' => $this->request()->input('description'),
                'price' => $this->request()->input('price'),
                'category' => $this->request()->input('category')
            ]);
        }

        $this->redirect('/admin/dashboard/goods_and_services');
    }

    public function addNewProductSale()
    {
        $labels = [
            'product_name' => 'Товар',
            'product_amount' => 'Кол-во товара'
        ];

        $validation = $this->request()->validate([
            'product_name' => ['required'],
            'product_amount' => ['required']
        ], $labels);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/admin/dashboard/sale_service');
            dd('Проверка не пройдена', $this->request()->errors());
        }

        if ($this->getDatabase()->first_found_in_db('Product', ['name' => $this->request()->input('product_name')])) {
            dd('Таблица уже существует');
        } else {
            $Product_sale = $this->getDatabase()->insert('Product_Sale', [
                'product_name' => $this->request()->input('product_name'),
                'product_amount' => $this->request()->input('product_amount'),
            ]);
        }

        $this->redirect('/admin/dashboard/service_sales');
    }
}
