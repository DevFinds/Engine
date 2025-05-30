<?php
namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\CompanyService;
use Source\Services\CompanyTypeService;
use Source\Services\EmployeeService;
use Source\Services\SupplierService;
use Source\Services\CarClassesService; // Исправлено

class ManageCompanyController extends Controller
{
    public function index()
    {
        $companies = new CompanyService($this->getDatabase());
        $company_types = new CompanyTypeService($this->getDatabase());
        $employees_service = new EmployeeService($this->getDatabase());
        $suppliers_service = new SupplierService($this->getDatabase());
        $car_classes_service = new CarClassesService($this->getDatabase()); // Исправлено
        
        $suppliers = $suppliers_service->getAllFromDB();
        $car_classes = $car_classes_service->getAllFromDB();
        
        $this->render('/admin/dashboard/company_managments', [
            'companies' => $companies, 
            'company_types' => $company_types,
            'employees_service' => $employees_service,
            'suppliers' => $suppliers,
            'car_classes' => $car_classes
        ]);
    }

    public function addCarClass()
    {
        $labels = [
            'name' => 'Название',
            'markup' => 'Доплата (руб.)'
        ];

        $validation = $this->request()->validate([
            'name' => ['required'],
            'markup' => ['required', 'numeric', 'min:0']
        ], $labels);

        if (!$validation) {
            $errors = implode(', ', array_merge(...array_values($this->request()->errors())));
            $this->session()->set('error', 'Ошибки валидации: ' . $errors);
            return $this->redirect('/admin/dashboard/company_managments');
        }

        try {
            $this->getDatabase()->beginTransaction();
            $car_classes_service = new CarClassesService($this->getDatabase()); // Исправлено
            $result = $car_classes_service->add([
                'name' => $this->request()->input('name'),
                'markup' => $this->request()->input('markup')
            ]);

            $this->getDatabase()->commit();
            $this->session()->set('success', 'Класс автомобиля успешно добавлен');
            return $this->redirect('/admin/dashboard/company_managments');
        } catch (\Exception $e) {
            $this->getDatabase()->rollBack();
            error_log("ManageCompanyController::addCarClass - Ошибка: " . $e->getMessage());
            $this->session()->set('error', 'Ошибка при добавлении класса автомобиля: ' . $e->getMessage());
            return $this->redirect('/admin/dashboard/company_managments');
        }
    }

    public function getCarClass($id)
    {
        try {
            $car_classes_service = new CarClassesService($this->getDatabase()); // Исправлено
            $car_class = $car_classes_service->getById($id);

            if (!$car_class) {
                return $this->jsonResponse(['error' => 'Класс автомобиля не найден'], 404);
            }

            return $this->jsonResponse([
                'id' => $car_class->id(),
                'name' => $car_class->name(),
                'markup' => $car_class->markup()
            ]);
        } catch (\Exception $e) {
            error_log("ManageCompanyController::getCarClass - Ошибка: " . $e->getMessage());
            return $this->jsonResponse(['error' => 'Ошибка сервера: ' . $e->getMessage()], 500);
        }
    }

    public function editCarClass()
    {
        $labels = [
            'id' => 'ID',
            'name' => 'Название',
            'markup' => 'Доплата (руб.)'
        ];

        $validation = $this->request()->validate([
            'id' => ['required', 'numeric'],
            'name' => ['required'],
            'markup' => ['required', 'numeric', 'min:0']
        ], $labels);

        if (!$validation) {
            $errors = implode(', ', array_merge(...array_values($this->request()->errors())));
            $this->session()->set('error', 'Ошибки валидации: ' . $errors);
            return $this->redirect('/admin/dashboard/company_managments');
        }

        try {
            $this->getDatabase()->beginTransaction();
            $car_classes_service = new CarClassesService($this->getDatabase()); // Исправлено
            $result = $car_classes_service->update($this->request()->input('id'), [
                'name' => $this->request()->input('name'),
                'markup' => $this->request()->input('markup')
            ]);

            if (!$result) {
                throw new \Exception('Не удалось обновить класс автомобиля');
            }

            $this->getDatabase()->commit();
            $this->session()->set('success', 'Класс автомобиля успешно обновлен');
            return $this->redirect('/admin/dashboard/company_managments');
        } catch (\Exception $e) {
            $this->getDatabase()->rollBack();
            error_log("ManageCompanyController::editCarClass - Ошибка: " . $e->getMessage());
            $this->session()->set('error', 'Ошибка при обновлении класса автомобиля: ' . $e->getMessage());
            return $this->redirect('/admin/dashboard/company_managments');
        }
    }

    public function deleteCarClass($id)
    {
        try {
            $this->getDatabase()->beginTransaction();
            $car_classes_service = new CarClassesService($this->getDatabase()); // Исправлено
            $result = $car_classes_service->delete($id);

            if (!$result) {
                return $this->jsonResponse(['error' => 'Класс автомобиля не найден'], 404);
            }

            $this->getDatabase()->commit();
            return $this->jsonResponse(['status' => 'success']);
        } catch (\Exception $e) {
            $this->getDatabase()->rollBack();
            error_log("ManageCompanyController::deleteCarClass - Ошибка: " . $e->getMessage());
            return $this->jsonResponse(['error' => 'Ошибка при удалении класса автомобиля: ' . $e->getMessage()], 500);
        }
    }
}