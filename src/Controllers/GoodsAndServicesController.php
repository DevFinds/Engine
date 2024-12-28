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
        // 1. Проверка полей, например, payment_type
        $validation = $this->request()->validate([
            'payment_type' => ['required'],
            // Можем проверить наличие products, но это сложнее (много полей)
        ], [
            'payment_type' => 'Тип оплаты'
        ]);

        if (!$validation) {
            // Вывод ошибок/редирект
            $this->redirect('/admin/dashboard/service_sales');
            return;
        }

        // 2. Получаем массив позиций
        // Пример: products[0][product_id] = 4, products[0][amount] = 2, ...
        $productLines = $this->request()->input('products');
        if (!is_array($productLines) || empty($productLines)) {
            $this->session()->set('error', 'Не выбраны товары');
            $this->redirect('/admin/dashboard/service_sales');
            return;
        }

        $paymentType = $this->request()->input('payment_type');
        $grandTotal = 0;

        // 3. Перебираем все строки
        foreach ($productLines as $line) {
            // проверим, что есть product_id и amount
            if (empty($line['product_id']) || empty($line['amount'])) {
                continue; // или обработать как ошибку
            }

            // Найдем товар в базе (по id)
            $product = $this->getDatabase()->first_found_in_db('Product', ['id' => $line['product_id']]);
            if (!$product) {
                // Товар не найден — можно пропустить или вернуть ошибку
                continue;
            }

            $amount = (int)$line['amount'];
            $price  = (float)$product['sale_price'];
            $lineTotal = $price * $amount;

            // 4. Записываем в таблицу Product_Sale
            $productSaleId = $this->getDatabase()->insert('Product_Sale', [
                'product_id' => $product['id'],      // например, сохраняем текстом
                'payment_method' => $paymentType
            ]);

            // 5. Суммируем к общему итогу
            $grandTotal += $lineTotal;
        }

        // 6. Создаем одну запись в Transaction на всю сумму
        $this->getDatabase()->insert('Transaction', [
            'sum' => $grandTotal,
            'transaction_type_id' => 2,  // допустим, 2 = продажа товара
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // 7. Редирект
        $this->redirect('/admin/dashboard/service_sales');
    }


    public function addNewServiceSale()
    {
        $labels = [
            'service_id' => 'Услуга',
            'employee_id' => 'Сотрудник',
            'car_number' => 'Номер машины',
            'car_model' => 'Модель машины',
            'car_brand' => 'Марка машины',
            'payment_type' => 'Тип оплаты'
        ];

        $validation = $this->request()->validate([
            'service_id' => ['required'],
            'employee_id' => ['required'],
            'car_number' => ['required'],
            'car_model' => ['required'],
            'car_brand' => ['required'],
            'payment_type' => ['required']
        ], $labels);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->redirect('/admin/dashboard/goods_and_services');
            return;
        }

        $this->getDatabase()->insert('Service_Sale', [
            'service_id' => $this->request()->input('service_id'),
            'employee_id' => $this->request()->input('employee_id'),
            'car_number' => $this->request()->input('car_number'),
            'car_model' => $this->request()->input('car_model'),
            'car_brand' => $this->request()->input('car_brand'),
            'payment_method' => $this->request()->input('payment_type')
        ]);

        $service = $this->getDatabase()->first_found_in_db('Service', ['id' => $this->request()->input('service_id')]);
        $this->getDatabase()->insert('Transaction', [
            'sum' => $service['price'],
            'transaction_type_id' => 3
        ]);

        $this->redirect('/admin/dashboard/service_sales');
    }
}
