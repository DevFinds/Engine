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
            'warehouse_id' => 'Склад',
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
            return;
        }

        $existingProduct = $this->getDatabase()->first_found_in_db('Product', [
            'name' => $this->request()->input('name'),
            'warehouse_id' => $this->request()->input('warehouse_id')
        ]);

        if ($existingProduct) {
            $this->getDatabase()->update('Product', [
                'amount' => $existingProduct['amount'] + $this->request()->input('amount')
            ], [
                'id' => $existingProduct['id']
            ]);
        } else {
            $this->getDatabase()->insert('Product', [
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
            return;
        }

        $existingService = $this->getDatabase()->first_found_in_db('Service', ['name' => $this->request()->input('name')]);

        if ($existingService) {
            $this->session()->set('error', 'Такая услуга уже существует');
            $this->redirect('/admin/dashboard/goods_and_services');
            return;
        }

        $this->getDatabase()->insert('Service', [
            'name' => $this->request()->input('name'),
            'description' => $this->request()->input('description'),
            'price' => $this->request()->input('price'),
            'category' => $this->request()->input('category')
        ]);

        $this->redirect('/admin/dashboard/goods_and_services');
    }


    public function addNewProductSale()
    {
        // Валидация, e.g. payment_type required
        $validation = $this->request()->validate([
            'payment_type' => ['required']
        ], [
            'payment_type' => 'Тип оплаты'
        ]);

        if (!$validation) {
            // ...
            return;
        }

        // Получаем массив products
        $lines = $this->request()->input('products');
        if (!is_array($lines) || empty($lines)) {
            $this->session()->set('error', 'Не выбраны товары');
            $this->redirect('/admin/dashboard/service_sales');
            return;
        }

        $paymentType = $this->request()->input('payment_type');
        $grandTotal = 0;

        foreach ($lines as $idx => $line) {
            $productWarehouseVal = $line['product_warehouse'] ?? null; // e.g. "4_1"
            $amount = (int)($line['amount'] ?? 0);

            if (!$productWarehouseVal || $amount < 1) {
                continue;
            }

            list($productId, $warehouseId) = explode('_', $productWarehouseVal);

            // Ищем в DB
            $productRow = $this->getDatabase()->first_found_in_db('Product', [
                'id' => $productId,
                'warehouse_id' => $warehouseId
            ]);
            if (!$productRow) {
                // Неверное значение, пропускаем
                continue;
            }

            $price = (float)$productRow['sale_price'];
            $lineTotal = $price * $amount;
            $grandTotal += $lineTotal;

            // Запись в Product_Sale
            $this->getDatabase()->insert('Product_Sale', [
                'product_id' => $productRow['id'],  // или product_id => $productId
                'total_amount' => $grandTotal,
                'payment_method' => $paymentType
            ]);

            //Можно уменьшить остаток
            $newAmount = max(0, $productRow['amount'] - $amount);
            $this->getDatabase()->update('Product', ['amount' => $newAmount], [
                'id' => $productId,
                'warehouse_id' => $warehouseId
            ]);
        }

        // Итоговая транзакция
        $this->getDatabase()->insert('Transaction', [
            'sum' => $grandTotal,
            'transaction_type_id' => 2,  // допустим, 2 = продажа
        ]);

        $this->redirect('/admin/dashboard/service_sales');
    }




    public function addNewServiceSale()
    {
        // 1. Валидация общих полей
        $labels = [
            // 'service_id' => 'Услуга', // убираем
            'employee_id' => 'Сотрудник',
            'car_number' => 'Номер машины',
            'car_model' => 'Модель машины',
            'car_brand' => 'Марка машины',
            'payment_type' => 'Тип оплаты'
        ];

        $validation = $this->request()->validate([
            // убираем 'service_id' => ['required']
            'employee_id' => ['required'],
            'car_number'  => ['required'],
            'car_model'   => ['required'],
            'car_brand'   => ['required'],
            'payment_type' => ['required']
            // 'services' => ['required_array'] // опционально, если доработан валидатор
        ], $labels);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            dd($this->request()->errors());
            return;
        }

        // 2. Получаем массив услуг
        $serviceLines = $this->request()->input('services');
        if (!is_array($serviceLines) || empty($serviceLines)) {
            $this->session()->set('error', 'Не выбрано ни одной услуги');
            $this->redirect('/admin/dashboard/service_sales');
            return;
        }

        // 3. Получаем общие поля
        $employeeId = $this->request()->input('employee_id');
        $carNumber  = $this->request()->input('car_number');
        $carModel   = $this->request()->input('car_model');
        $carBrand   = $this->request()->input('car_brand');
        $paymentType = $this->request()->input('payment_type');

        $grandTotal = 0;

        // 4. Перебираем все выбранные услуги
        foreach ($serviceLines as $idx => $line) {
            $servId = $line['service_id'] ?? null;
            if (!$servId) {
                // пропускаем
                continue;
            }

            // Находим услугу в таблице Service (ID = $servId)
            $serviceRow = $this->getDatabase()->first_found_in_db('Service', ['id' => $servId]);
            if (!$serviceRow) {
                // услуга не найдена, пропускаем
                continue;
            }

            $price = (float)$serviceRow['price'];
            $grandTotal += $price;

            // Записываем отдельную продажу в Service_Sale
            $this->getDatabase()->insert('Service_Sale', [
                'service_id'    => $servId,
                'employee_id'   => $employeeId,
                'total_amount'  => $grandTotal,
                'car_number'    => $carNumber,
                'car_model'     => $carModel,
                'car_brand'     => $carBrand,
                'payment_method' => $paymentType
            ]);
        }

        // 5. Вставляем в Transaction общую сумму
        $this->getDatabase()->insert('Transaction', [
            'sum' => $grandTotal,
            'transaction_type_id' => 3, // 3 = продажа услуги
        ]);

        $this->redirect('/admin/dashboard/service_sales');
    }
}
