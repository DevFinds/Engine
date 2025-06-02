<?php

namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\CompanyService;
use Source\Services\CompanyTypeService;
use Source\Services\EmployeeService;
use Source\Services\SupplierService;
use Source\Services\CarClassesService;

class ManageCompanyController extends Controller
{
    public function index()
    {
        $companies = new CompanyService($this->getDatabase());
        $company_types = new CompanyTypeService($this->getDatabase());
        $employees_service = new EmployeeService($this->getDatabase());
        $suppliers_service = new SupplierService($this->getDatabase());
        $car_classes_service = new CarClassesService($this->getDatabase());

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
            return $this->jsonResponse(['error' => 'Ошибки валидации: ' . $errors], 400);
        }

        try {
            $this->getDatabase()->beginTransaction();
            $car_classes_service = new CarClassesService($this->getDatabase());
            $result = $car_classes_service->add([
                'name' => $this->request()->input('name'),
                'markup' => $this->request()->input('markup')
            ]);

            $this->getDatabase()->commit();
            return $this->jsonResponse(['status' => 'success']);
        } catch (\Exception $e) {
            $this->getDatabase()->rollBack();
            error_log("ManageCompanyController::addCarClass - Ошибка: " . $e->getMessage());
            return $this->jsonResponse(['error' => 'Ошибка при добавлении: ' . $e->getMessage()], 500);
        }
    }

    public function getCarClass($id)
    {
        try {
            $car_classes_service = new CarClassesService($this->getDatabase());
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
            return $this->jsonResponse(['error' => 'Ошибки валидации: ' . $errors], 400);
        }

        try {
            $this->getDatabase()->beginTransaction();
            $car_classes_service = new CarClassesService($this->getDatabase());
            $result = $car_classes_service->update($this->request()->input('id'), [
                'name' => $this->request()->input('name'),
                'markup' => $this->request()->input('markup')
            ]);

            if (!$result) {
                throw new \Exception('Не удалось обновить класс автомобиля');
            }

            $this->getDatabase()->commit();
            return $this->jsonResponse(['status' => 'success']);
        } catch (\Exception $e) {
            $this->getDatabase()->rollBack();
            error_log("ManageCompanyController::editCarClass - Ошибка: " . $e->getMessage());
            return $this->jsonResponse(['error' => 'Ошибка при обновлении: ' . $e->getMessage()], 500);
        }
    }

    public function deleteCarClass($id)
    {
        try {
            $this->getDatabase()->beginTransaction();
            $car_classes_service = new CarClassesService($this->getDatabase());
            $result = $car_classes_service->delete($id);

            if (!$result) {
                return $this->jsonResponse(['error' => 'Класс автомобиля не найден'], 404);
            }

            $this->getDatabase()->commit();
            return $this->jsonResponse(['status' => 'success']);
        } catch (\Exception $e) {
            $this->getDatabase()->rollBack();
            error_log("ManageCompanyController::deleteCarClass - Ошибка: " . $e->getMessage());
            return $this->jsonResponse(['error' => 'Ошибка при удалении: ' . $e->getMessage()], 500);
        }
    }


    public function addSupplier()
    {
        // Метки для полей
        $labels = [
            'name' => 'Название',
            'inn' => 'ИНН',
            'ogrn' => 'ОГРН',
            'legal_address' => 'Юридический адрес',
            'actual_address' => 'Фактический адрес',
            'phone' => 'Телефон',
            'email' => 'Email',
            'contact_info' => 'Контактная информация'
        ];

        // Валидация данных формы
        $validation = $this->request()->validate([
            'name' => ['required'],
            'inn' => ['required'],
            'ogrn' => ['required'],
            'legal_address' => ['required'],
            'actual_address' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
            'contact_info' => ['required']
        ], $labels);

        // Если валидация не прошла, сохраняем ошибки и перенаправляем
        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->session()->set('error', 'Ошибки валидации: ' . implode(', ', $this->request()->errors()));
            $this->redirect('/admin/dashboard/company_managments');
            return;
        }

        // Получаем данные из формы
        $name = $this->request()->input('name');
        $inn = $this->request()->input('inn');
        $ogrn = $this->request()->input('ogrn');
        $legal_address = $this->request()->input('legal_address');
        $actual_address = $this->request()->input('actual_address');
        $phone = $this->request()->input('phone');
        $email = $this->request()->input('email');
        $contact_info = $this->request()->input('contact_info');

        // Отладка: выводим данные
        error_log("Данные формы: " . print_r([
            'name' => $name,
            'inn' => $inn,
            'ogrn' => $ogrn,
            'legal_address' => $legal_address,
            'actual_address' => $actual_address,
            'phone' => $phone,
            'email' => $email,
            'contact_info' => $contact_info
        ], true));

        try {
            // Начинаем транзакцию
            $this->getDatabase()->beginTransaction();

            // Проверяем, существует ли контрагент с таким ИНН
            $existingSupplier = $this->getDatabase()->first_found_in_db('Supplier', [
                'inn' => $inn
            ]);

            if ($existingSupplier) {
                throw new \Exception('Контрагент с таким ИНН уже существует');
            }

            // Добавляем нового контрагента
            $result = $this->getDatabase()->insert('Supplier', [
                'name' => $name,
                'inn' => $inn,
                'ogrn' => $ogrn,
                'legal_address' => $legal_address,
                'actual_address' => $actual_address,
                'phone' => $phone,
                'email' => $email,
                'contact_info' => $contact_info
            ]);

            // Отладка: проверяем результат вставки
            error_log("Результат вставки: " . ($result ? 'Успешно' : 'Не удалось'));

            // Подтверждаем транзакцию
            $this->getDatabase()->commit();

            // Устанавливаем сообщение об успехе
            $this->session()->set('success', 'Контрагент успешно добавлен');
            $this->redirect('/admin/dashboard/company_managments');
        } catch (\Exception $e) {
            // Откатываем транзакцию в случае ошибки
            $this->getDatabase()->rollBack();
            error_log("Ошибка: " . $e->getMessage());
            $this->session()->set('error', 'Ошибка при добавлении контрагента: ' . $e->getMessage());
            $this->redirect('/admin/dashboard/company_managments');
        }
    }

    public function getSupplier($id)
    {
        try {
            error_log("ManageCompanyController::getSupplier - Запрос для ID: " . $id);
            $supplierService = new SupplierService($this->getDatabase());
            $supplier = $supplierService->getSupplierById($id);

            if (!$supplier) {
                error_log("ManageCompanyController::getSupplier - Контрагент с ID $id не найден");
                return $this->jsonResponse(['error' => 'Контрагент не найден'], 404);
            }

            $response = [
                'id' => $supplier->id(),
                'name' => $supplier->name(),
                'inn' => $supplier->inn(),
                'ogrn' => $supplier->ogrn(),
                'legal_address' => $supplier->legal_address(),
                'actual_address' => $supplier->actual_address(),
                'phone' => $supplier->phone(),
                'email' => $supplier->email(),
                'contact_info' => $supplier->contact_info(),
            ];

            error_log("ManageCompanyController::getSupplier - Данные контрагента: " . json_encode($response));
            return $this->jsonResponse($response);
        } catch (\Exception $e) {
            error_log("ManageCompanyController::getSupplier - Ошибка: " . $e->getMessage());
            return $this->jsonResponse(['error' => 'Ошибка сервера: ' . $e->getMessage()], 500);
        }
    }

    public function editSupplier()
    {
        $labels = [
            'name' => 'Название',
            'inn' => 'ИНН',
            'ogrn' => 'ОГРН',
            'legal_address' => 'Юридический адрес',
            'actual_address' => 'Фактический адрес',
            'phone' => 'Телефон',
            'email' => 'Email',
            'contact_info' => 'Контактная информация'
        ];

        $validation = $this->request()->validate([
            'id' => ['required'],
            'name' => ['required'],
            'inn' => ['required'],
            'ogrn' => ['required'],
            'legal_address' => ['required'],
            'actual_address' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
            'contact_info' => ['required']
        ], $labels);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->session()->set('error', 'Ошибки валидации: ' . implode(', ', $this->request()->errors()));
            $this->redirect('/admin/dashboard/company_managments');
            return;
        }

        $id = $this->request()->input('id');
        $name = $this->request()->input('name');
        $inn = $this->request()->input('inn');
        $ogrn = $this->request()->input('ogrn');
        $legal_address = $this->request()->input('legal_address');
        $actual_address = $this->request()->input('actual_address');
        $phone = $this->request()->input('phone');
        $email = $this->request()->input('email');
        $contact_info = $this->request()->input('contact_info');

        try {
            $this->getDatabase()->beginTransaction();

            $existingSupplier = $this->getDatabase()->first_found_in_db('Supplier', [
                'inn' => $inn,
                'id' => ['operator' => '!=', 'value' => $id]
            ]);

            if ($existingSupplier) {
                throw new \Exception('Контрагент с таким ИНН уже существует');
            }

            $result = $this->getDatabase()->update('Supplier', [
                'name' => $name,
                'inn' => $inn,
                'ogrn' => $ogrn,
                'legal_address' => $legal_address,
                'actual_address' => $actual_address,
                'phone' => $phone,
                'email' => $email,
                'contact_info' => $contact_info
            ], ['id' => $id]);

            error_log("Результат обновления: " . ($result ? 'Успешно' : 'Не удалось'));

            $this->getDatabase()->commit();

            $this->session()->set('success', 'Контрагент успешно обновлен');
            $this->redirect('/admin/dashboard/company_managments');
        } catch (\Exception $e) {
            $this->getDatabase()->rollBack();
            error_log("Ошибка: " . $e->getMessage());
            $this->session()->set('error', 'Ошибка при обновлении контрагента: ' . $e->getMessage());
            $this->redirect('/admin/dashboard/company_managments');
        }
    }

    public function deleteSupplier($id)
    {
        try {
            error_log("ManageCompanyController::deleteSupplier - Начало удаления для ID: $id");
            $this->getDatabase()->beginTransaction();

            $supplierService = new SupplierService($this->getDatabase());

            // Проверяем, есть ли связанные продукты
            if ($supplierService->hasRelatedProducts($id)) {
                error_log("ManageCompanyController::deleteSupplier - Найдены связанные продукты для ID: $id");
                throw new \Exception('Нельзя удалить контрагента, так как он связан с продуктами. Сначала удалите связанные продукты.');
            }

            // Удаляем контрагента
            error_log("ManageCompanyController::deleteSupplier - Попытка удаления контрагента ID: $id");
            $result = $this->getDatabase()->delete('Supplier', ['id' => $id]);

            if (!$result) {
                error_log("ManageCompanyController::deleteSupplier - Контрагент с ID $id не найден");
                throw new \Exception('Контрагент не найден или не может быть удален.');
            }

            error_log("ManageCompanyController::deleteSupplier - Успешное удаление контрагента ID: $id");
            $this->getDatabase()->commit();

            $this->session()->set('success', 'Контрагент успешно удален');
            $this->redirect('/admin/dashboard/company_managments');
        } catch (\Exception $e) {
            $this->getDatabase()->rollBack();
            error_log("ManageCompanyController::deleteSupplier - Ошибка: " . $e->getMessage());
            $this->session()->set('error', 'Ошибка при удалении контрагента: ' . $e->getMessage());
            $this->redirect('/admin/dashboard/company_managments');
        }
    }

    protected function jsonResponse($data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
}
