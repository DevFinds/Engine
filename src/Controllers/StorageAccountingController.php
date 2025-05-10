<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\ProductService;
use Source\Services\SupplierService;
use Exception;
use FPDF;
use Source\Services\CompanyService;
use Source\Services\ServiceService;
use Source\Services\WarehouseService;
use Source\Services\CompanyTypeService;

class StorageAccountingController extends Controller
{
    public function index()
    {
        
        $products = new ProductService($this->getDatabase());
        $suppliers = new SupplierService($this->getDatabase());
        $this->render('/admin/dashboard/storage_accounting', [
            'products' => $products,
            'suppliers' => $suppliers
        ]);

        
    }

    public function moveProducts()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || !isset($input['source_warehouse_id'], $input['destination_warehouse_id'], $input['products'])) {
            echo json_encode(['success' => false, 'message' => 'Неверные данные запроса']);
            return;
        }
        $source_warehouse_id = $input['source_warehouse_id'];
        $destination_warehouse_id = $input['destination_warehouse_id'];
        $products = $input['products'];

        try {
            $this->getDatabase()->beginTransaction(); // Начать транзакцию

            foreach ($products as $product) {
                $product_id = $product['product_id'];
                $quantity = $product['quantity'];

                $source_product = $this->getDatabase()->first_found_in_db('Product', [
                    'id' => $product_id,
                    'warehouse_id' => $source_warehouse_id
                ]);

                if (!$source_product) {
                    throw new Exception("Товар с ID $product_id не найден на исходном складе");
                }

                if ($source_product['amount'] < $quantity) {
                    throw new Exception("Недостаточно товара '{$source_product['name']}' на складе");
                }

                $this->getDatabase()->update('Product', [
                    'amount' => $source_product['amount'] - $quantity
                ], ['id' => $product_id]);

                $existing_product = $this->getDatabase()->first_found_in_db('Product', [
                    'name' => $source_product['name'],
                    'warehouse_id' => $destination_warehouse_id
                ]);

                if ($existing_product) {
                    $this->getDatabase()->update('Product', [
                        'amount' => $existing_product['amount'] + $quantity
                    ], ['id' => $existing_product['id']]);
                } else {
                    $this->getDatabase()->insert('Product', [
                        'name' => $source_product['name'],
                        'amount' => $quantity,
                        'created_at' => date('Y-m-d H:i:s'),
                        'unit_measurement' => $source_product['unit_measurement'],
                        'purchase_price' => $source_product['purchase_price'],
                        'sale_price' => $source_product['sale_price'],
                        'supplier_id' => $source_product['supplier_id'],
                        'warehouse_id' => $destination_warehouse_id,
                        'description' => $source_product['description']
                    ]);
                }
            }

            $this->getDatabase()->commit(); // Подтвердить транзакцию
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $this->getDatabase()->rollBack(); // Откатить транзакцию при ошибке
            echo json_encode(['success' => false, 'message' => 'Ошибка при перемещении товаров: ' . $e->getMessage()]);
        }
    }

    public function deleteProducts()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        error_log('Входные данные deleteProducts: ' . print_r($input, true));
    
        if (!$input || !isset($input['products'], $input['warehouse_id'])) {
            error_log('Ошибка: Неверные данные запроса');
            echo json_encode(['success' => false, 'message' => 'Неверные данные запроса']);
            return;
        }
    
        $products = $input['products'];
        $warehouse_id = $input['warehouse_id'];
    
        try {
            $this->getDatabase()->beginTransaction();
    
            foreach ($products as $product) {
                $product_id = $product['product_id'];
                $quantity = $product['quantity'];
                error_log("Обработка товара ID: $product_id, Количество: $quantity");
    
                $existing_product = $this->getDatabase()->first_found_in_db('Product', [
                    'id' => $product_id,
                    'warehouse_id' => $warehouse_id
                ]);
    
                if (!$existing_product) {
                    error_log("Ошибка: Товар ID $product_id не найден на складе $warehouse_id");
                    throw new Exception("Товар с ID $product_id не найден на складе");
                }
    
                if ($existing_product['amount'] < $quantity) {
                    error_log("Ошибка: Недостаточно товара '{$existing_product['name']}' (доступно: {$existing_product['amount']}, запрошено: $quantity)");
                    throw new Exception("Недостаточно товара '{$existing_product['name']}' для удаления");
                }
    
                $new_amount = $existing_product['amount'] - $quantity;
                error_log("Новое количество для ID $product_id: $new_amount");
    
                if ($new_amount > 0) {
                    $this->getDatabase()->update('Product', [
                        'amount' => $new_amount
                    ], [
                        'id' => $product_id,
                        'warehouse_id' => $warehouse_id
                    ]);
                } else {
                    $this->getDatabase()->delete('Product', [
                        'id' => $product_id,
                        'warehouse_id' => $warehouse_id
                    ]);
                }
            }
    
            $this->getDatabase()->commit();
            error_log('Удаление успешно завершено');
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $this->getDatabase()->rollBack();
            error_log('Ошибка при удалении: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Ошибка при удалении товаров: ' . $e->getMessage()]);
        }
    }


    public function addIncome()
    {
        $labels = [
            'supplier_id' => 'Поставщик',
            'product_id' => 'Товар',
            'amount' => 'Количество',
            'created_at' => 'Дата поступления',
            'warehouse_id' => 'Склад'
        ];

        // Валидация данных формы
        $validation = $this->request()->validate([
            'supplier_id' => ['required', 'integer'],
            'product_id' => ['required', 'integer'],
            'amount' => ['required', 'integer', 'min:1'],
            'created_at' => ['required', 'date'],
            'warehouse_id' => ['required', 'integer']
        ], $labels);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->redirect('/admin/dashboard/storage_accounting');
            return;
        }

        $product_id = $this->request()->input('product_id');
        $warehouse_id = $this->request()->input('warehouse_id');
        $amount = $this->request()->input('amount');
        $created_at = $this->request()->input('created_at');
        $supplier_id = $this->request()->input('supplier_id');

        try {
            $this->getDatabase()->beginTransaction();

            // Проверяем, существует ли товар на указанном складе
            $existingProduct = $this->getDatabase()->first_found_in_db('Product', [
                'id' => $product_id,
                'warehouse_id' => $warehouse_id
            ]);

            if ($existingProduct) {
                // Обновляем количество товара
                $this->getDatabase()->update('Product', [
                    'amount' => $existingProduct['amount'] + $amount,
                    'created_at' => $created_at,
                    'supplier_id' => $supplier_id
                ], [
                    'id' => $product_id,
                    'warehouse_id' => $warehouse_id
                ]);
            } else {
                // Если товара нет, нужно получить данные существующего товара для создания новой записи
                $product = $this->getDatabase()->first_found_in_db('Product', [
                    'id' => $product_id
                ]);

                if (!$product) {
                    throw new Exception('Товар не найден в базе данных');
                }

                // Создаём новую запись для товара на другом складе
                $this->getDatabase()->insert('Product', [
                    'name' => $product['name'],
                    'amount' => $amount,
                    'created_at' => $created_at,
                    'unit_measurement' => $product['unit_measurement'],
                    'purchase_price' => $product['purchase_price'],
                    'sale_price' => $product['sale_price'],
                    'supplier_id' => $supplier_id,
                    'warehouse_id' => $warehouse_id,
                    'description' => $product['description']
                ]);
            }

            $this->getDatabase()->commit();
            $this->session()->set('success', 'Товар успешно добавлен на склад');
            $this->redirect('/admin/dashboard/storage_accounting');
        } catch (Exception $e) {
            $this->getDatabase()->rollBack();
            $this->session()->set('error', 'Ошибка при добавлении товара: ' . $e->getMessage());
            $this->redirect('/admin/dashboard/storage_accounting');
        }
    }
}
