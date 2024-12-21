<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\ServiceService;
use Source\Services\EmployeeService;

class ServiceController extends Controller
{
    public function index()
    {
        $serviceService = new ServiceService($this->getDatabase());
        $employeeService = new EmployeeService($this->getDatabase());
        $this->render('/admin/dashboard/service_sales', [
            'service' => $serviceService,
            'employees' => $employeeService
        ]);
    }

    public function addNewServiceSale()
    {
        $validation = $this->request()->validate([
            'service_id' => ['required'],
            'employee_id' => ['required'],
            'car_number' => ['required'],
            'car_model' => ['required'],
            'car_brand' => ['required'],
            'payment_type' => ['required']
        ]);

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
            $Service_sale = $this->getDatabase()->insert('Service_Sale', [
                'service_id' => $this->request()->input('service_id'),
                'employee_id' => $this->request()->input('employee_id'),
                'car_number' => $this->request()->input('car_number'),
                'car_model' => $this->request()->input('car_model'),
                'car_brand' => $this->request()->input('car_brand'),
                'payment_method' => $this->request()->input('payment_type')
            ]);
        }




        $this->redirect('/admin/dashboard/service_sales');
    }
}
