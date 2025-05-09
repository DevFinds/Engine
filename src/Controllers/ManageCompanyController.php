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
        $suppliers_service = new SupplierService($this->getDatabase());
        
        $suppliers = $suppliers_service->getAllFromDB(); // Получаем массив поставщиков
        
        $this->render('/admin/dashboard/company_managments', [
            'companies' => $companies, 
            'company_types' => $company_types,
            'employees_service' => $employees_service,
            'suppliers' => $suppliers // Передаем массив поставщиков
        ]);
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
}
