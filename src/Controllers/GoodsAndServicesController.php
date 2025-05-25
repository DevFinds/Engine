<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Exception;
use FPDF;
use Source\Events\LogActionEvent;
use Source\Listeners\LogActionListener;
use Source\Services\CompanyService;
use Source\Services\ProductService;
use Source\Services\ServiceService;
use Source\Services\WarehouseService;
use Source\Services\CompanyTypeService;
use Source\Services\SupplierService;

class GoodsAndServicesController extends Controller
{

    public function index()
    {

        $company_service = new CompanyService($this->getDatabase());
        $company_type_service = new CompanyTypeService($this->getDatabase());
        $suppliers_service = new SupplierService($this->getDatabase());
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
            'service_service' => $service_service,
            'suppliers_service' => $suppliers_service
        ]);
    }

    public function addNewGood()
    {
        $this->getEventManager()->addListener('log.action', new LogActionListener());
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

            $payload = [
                'action_name' => 'Добавление товара',
                'actor_id' => $this->getAuth()->getUser()->id(),
                'action_info' => [
                    'Товар' => $this->request()->input('name'),
                    'Количество' => $this->request()->input('amount'),
                    'Склад' => $this->request()->input('warehouse_id'),
                    'Поставщик' => $this->request()->input('supplier_id'),
                    'Ед. изм.' => $this->request()->input('unit_measurement'),
                    'Дата создания' => $this->request()->input('created_at'),
                    'Пользователь' => $this->getAuth()->getRole()->name() . " " . $this->getAuth()->getUser()->username() . " " . $this->getAuth()->getUser()->lastname()
                ]
            ];
            $event = new LogActionEvent($payload);
            $this->getEventManager()->dispatch($event);
        }

        $this->redirect('/admin/dashboard/goods_and_services');
    }


    public function addNewService()
    {
        $this->getEventManager()->addListener('log.action', new LogActionListener());
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

        $payload = [
            'action_name' => 'Добавление услуги',
            'actor_id' => $this->getAuth()->getUser()->id(),
            'action_info' => [
                'Услуга' => $this->request()->input('name'),
                'Цена' => $this->request()->input('price'),
                'Категория' => $this->request()->input('category'),
                'Описание' => $this->request()->input('description'),
                'Пользователь' => $this->getAuth()->getRole()->name() . " " . $this->getAuth()->getUser()->username() . " " . $this->getAuth()->getUser()->lastname()
            ]
        ];
        $event = new LogActionEvent($payload);
        $this->getEventManager()->dispatch($event);
        $this->redirect('/admin/dashboard/goods_and_services');
    }


    public function addNewProductSale()
    {
        $this->getEventManager()->addListener('log.action', new LogActionListener());
        $validation = $this->request()->validate([
            'payment_type' => ['required']
        ], [
            'payment_type' => 'Тип оплаты'
        ]);

        if (!$validation) {
            $this->session()->set('error', 'Не выбран тип оплаты.');
            $this->redirect('/admin/dashboard/service_sales');
            return;
        }

        $lines = $this->request()->input('products');
        if (!is_array($lines) || empty($lines)) {
            $this->session()->set('error', 'Не выбраны товары.');
            $this->redirect('/admin/dashboard/service_sales');
            return;
        }

        $paymentType = $this->request()->input('payment_type');
        $operatorName = $this->getAuth()->getUser()->username(); // Получаем имя текущего оператора
        $grandTotal = 0;

        // Инициализация чека
        $checkNumber = date('YmdHis');
        $cash = 0;
        $card = 0;
        $items = [];

        foreach ($lines as $line) {
            $productWarehouseVal = $line['product_warehouse'] ?? null;
            $amount = (int)($line['amount'] ?? 0);

            if (!$productWarehouseVal || $amount < 1) {
                continue;
            }

            list($productId, $warehouseId) = explode('_', $productWarehouseVal);

            $productRow = $this->getDatabase()->first_found_in_db('Product', [
                'id' => $productId,
                'warehouse_id' => $warehouseId
            ]);

            if (!$productRow) {
                continue;
            }

            $price = (float)$productRow['sale_price'];
            $lineTotal = $price * $amount;
            $grandTotal += $lineTotal;



            // Уменьшаем остаток товара
            $newAmount = max(0, $productRow['amount'] - $amount);
            $this->getDatabase()->update('Product', ['amount' => $newAmount], [
                'id' => $productId,
                'warehouse_id' => $warehouseId
            ]);

            $items[] = [
                'name' => $productRow['name'],
                'quantity' => $amount,
                'price' => $price,
                'total' => $lineTotal
            ];
        }

        $cash = $paymentType === 'cash' ? $grandTotal : 0;
        $card = $paymentType === 'card' ? $grandTotal : 0;

        try {
            $checkId = $this->createCheck([
                'check_number' => $checkNumber,
                'date' => date('Y-m-d H:i:s'),
                'total' => $grandTotal,
                'cash' => $cash,
                'card' => $card,
                'discount' => 0,
                'operator_name' => $operatorName,
                'car_number' => null,
                'change_amount' => 0,
                'report_type' => 'product',
                'car_model' => null,
                'car_brand' => null
            ]);

            $this->addCheckItems($checkId, $items);

            // Печать чека
            $payload = [
                'action_name' => 'Продажа товара',
                'actor_id' => $this->getAuth()->getUser()->id(),
                'action_info' => [
                    'Ссылка на чек' => '/admin/dashboard/check/preview/' . $checkId,
                    'Кассир' => $this->getAuth()->getRole()->name() . " " . $this->getAuth()->getUser()->username() . " " . $this->getAuth()->getUser()->lastname()
                ]
            ];
            $event = new LogActionEvent($payload);
            $this->getEventManager()->dispatch($event);
            $this->redirect('/admin/dashboard/check/preview/' . $checkId);
        } catch (Exception $e) {
            $this->session()->set('error', 'Ошибка при создании чека: ' . $e->getMessage());
            $this->redirect('/admin/dashboard/service_sales');
        }
    }

    public function addNewServiceSale()
    {
        $this->getEventManager()->addListener('log.action', new LogActionListener());
        $validation = $this->request()->validate([
            'employee_id' => ['required'],
            'state_number' => ['required'],
            'payment_type' => ['required']
        ], [
            'employee_id' => 'Сотрудник',
            'state_number' => 'Гос. номер',
            'payment_type' => 'Тип оплаты'
        ]);

        if (!$validation) {
            $this->session()->set('error', 'Не заполнены обязательные поля.');
            $this->redirect('/admin/dashboard/service_sales');
            return;
        }

        $serviceLines = $this->request()->input('services');
        if (!is_array($serviceLines) || empty($serviceLines)) {
            $this->session()->set('error', 'Не выбрано ни одной услуги.');
            $this->redirect('/admin/dashboard/service_sales');
            return;
        }

        // Поиск или создание машины
        $stateNumber = $this->request()->input('state_number');
        $car = $this->getDatabase()->first_found_in_db('Car', ['state_number' => $stateNumber]);
        if (!$car) {
            $carId = $this->getDatabase()->insert('Car', [
                'state_number' => $stateNumber,
                'car_brand' => $this->request()->input('car_brand'),
                'car_model' => null,
                'class_id' => $this->request()->input('class_id'),
                'client_id' => null,

            ]);
            $car = $this->getDatabase()->first_found_in_db('Car', ['id' => $carId]);
        } else {
            $carId = $car['id'];
        }

        $employeeId = $this->request()->input('employee_id');
        $paymentType = $this->request()->input('payment_type');
        $operatorName = $this->getAuth()->getUser()->username();
        $grandTotal = 0;
        $items = [];

        // Получаем класс автомобиля и процент наценки
        $classId = $car['class_id'];
        $carClass = $this->getDatabase()->first_found_in_db('Car_Classes', ['id' => $classId]);
        $percent = $carClass ? (float)$carClass['percent'] : 0.00;

        foreach ($serviceLines as $line) {
            $servId = $line['service_id'] ?? null;
            if (!$servId) continue;

            $serviceRow = $this->getDatabase()->first_found_in_db('Service', ['id' => $servId]);
            if (!$serviceRow) continue;

            $basePrice = (float)$serviceRow['price'];
            $markup = $basePrice * ($percent / 100);
            $adjustedPrice = $basePrice + $markup;
            $grandTotal += $adjustedPrice;

            $items[] = [
                'name' => $serviceRow['name'],
                'quantity' => 1,
                'price' => $adjustedPrice,
                'total' => $adjustedPrice
            ];

            $this->getDatabase()->insert('Service_Sale', [
                'service_id' => $servId,
                'employee_id' => $employeeId,
                'car_id' => $carId,
                'total_amount' => $adjustedPrice,
                'payment_method' => $paymentType
            ]);
        }

        $cash = $paymentType === 'cash' ? $grandTotal : 0;
        $card = $paymentType === 'card' ? $grandTotal : 0;

        try {
            $checkId = $this->createCheck([
                'check_number' => 'CHK' . time(),
                'date' => date('Y-m-d H:i:s'),
                'total' => $grandTotal,
                'cash' => $cash,
                'card' => $card,
                'discount' => 0,
                'operator_name' => $operatorName,
                'car_number' => $car['state_number'],
                'change_amount' => 0,
                'report_type' => 'service',
                'car_model' => $car['car_model'],
                'car_brand' => $car['car_brand']
            ]);

            $this->addCheckItems($checkId, $items);

            $payload = [
                'action_name' => 'Продажа услуги',
                'actor_id' => $this->getAuth()->getUser()->id(),
                'action_info' => [
                    'Ссылка на чек' => '/admin/dashboard/check/preview/' . $checkId,
                    'Кассир' => $this->getAuth()->getRole()->name() . " " .
                        $this->getAuth()->getUser()->username() . " " .
                        $this->getAuth()->getUser()->lastname()
                ]
            ];
            $event = new LogActionEvent($payload);
            $this->getEventManager()->dispatch($event);
            $this->redirect('/admin/dashboard/check/preview/' . $checkId);
        } catch (Exception $e) {
            $this->session()->set('error', 'Ошибка при создании чека: ' . $e->getMessage());
            $this->redirect('/admin/dashboard/service_sales');
        }
    }

    public function previewCheck($checkId)
    {
        try {
            // Получаем данные чека из таблицы checks
            $check = $this->getDatabase()->first_found_in_db('checks', ['id' => $checkId]);
            if (!$check) {
                $this->session()->set('error', 'Чек не найден.');
                dd($this->session()->get('error'));
                return;
            }

            // Получаем данные позиций из таблицы check_items
            $checkItems = $this->getDatabase()->get('check_items', ['check_id' => $checkId]);

            // Передаем данные чека и позиций в вид
            $this->render('/admin/preview_check', [
                'check' => $check,
                'items' => $checkItems
            ]);
        } catch (Exception $e) {
            $this->session()->set('error', 'Ошибка при загрузке чека: ' . $e->getMessage());
            dd($this->session()->get('error'));
        }
    }


    private function createCheck(array $data): int
    {
        try {
            return $this->getDatabase()->insert('checks', $data);
        } catch (Exception $e) {
            $this->session()->set('error', 'Ошибка создания чека: ' . $e->getMessage());
            throw $e;
        }
    }

    private function addCheckItems(int $checkId, array $items): void
    {
        foreach ($items as $item) {
            try {
                $this->getDatabase()->insert('check_items', [
                    'check_id' => $checkId,
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['total']
                ]);
            } catch (Exception $e) {
                $this->session()->set('error', 'Ошибка добавления позиции в чек: ' . $e->getMessage());
                throw $e;
            }
        }
    }

    

    public function editProduct()
    {
        $id = $this->request()->input('id');
        $data = [
            'name' => $this->request()->input('name'),
            'amount' => $this->request()->input('amount'),
            'created_at' => $this->request()->input('created_at'),
            'unit_measurement' => $this->request()->input('unit_measurement'),
            'purchase_price' => $this->request()->input('purchase_price'),
            'sale_price' => $this->request()->input('sale_price'),
            'supplier_id' => $this->request()->input('supplier_id'),
            'warehouse_id' => $this->request()->input('warehouse_id'),
            'description' => $this->request()->input('description')
        ];

        $this->getDatabase()->update('Product', $data, ['id' => $id]);
        $this->redirect('/admin/dashboard/goods_and_services');
    }

    public function deleteProduct()
    {
        ob_start(); // Начать буферизацию вывода
        header('Content-Type: application/json'); // Установить заголовок JSON
        try {
            // Получить и залогировать сырое тело запроса
            $rawInput = file_get_contents('php://input');
            error_log('deleteProduct raw input: ' . $rawInput);

            // Декодировать JSON
            $input = json_decode($rawInput, true);
            $id = $input['id'] ?? null;

            if (!$id) {
                error_log('deleteProduct: ID not provided');
                echo json_encode(['status' => 'error', 'message' => 'ID товара не указан']);
                ob_end_flush();
                return;
            }

            error_log('deleteProduct: Processing ID ' . $id);

            // Проверка существования товара
            $product = $this->getDatabase()->first_found_in_db('Product', ['id' => $id]);
            if (!$product) {
                error_log('deleteProduct: Product ID ' . $id . ' not found');
                echo json_encode(['status' => 'error', 'message' => 'Товар не найден']);
                ob_end_flush();
                return;
            }

            // Удаление связанных записей в check_items (если связь через name)
            // Замените 'name' на актуальный столбец, если связь другая
            $this->getDatabase()->delete('check_items', ['name' => $product['name']]);
            error_log('deleteProduct: Deleted related check_items for product name ' . $product['name']);

            // Удаление товара
            $result = $this->getDatabase()->delete('Product', ['id' => $id]);
            if ($result === false) {
                throw new Exception('Не удалось удалить товар');
            }
            error_log('deleteProduct: Successfully deleted product ID ' . $id);

            // Логирование действия
            $this->getEventManager()->addListener('log.action', new LogActionListener());
            $payload = [
                'action_name' => 'Удаление товара',
                'actor_id' => $this->getAuth()->getUser()->id(),
                'action_info' => [
                    'Товар' => $product['name'],
                    'Пользователь' => $this->getAuth()->getRole()->name() . " " . 
                                    $this->getAuth()->getUser()->username() . " " . 
                                    $this->getAuth()->getUser()->lastname()
                ]
            ];
            $event = new LogActionEvent($payload);
            $this->getEventManager()->dispatch($event);

            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            error_log('deleteProduct error for ID ' . ($id ?? 'unknown') . ': ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Ошибка при удалении товара: ' . $e->getMessage()]);
        }
        ob_end_flush();
    }

    public function editService()
    {
        $this->getEventManager()->addListener('log.action', new LogActionListener());
        $id = $this->request()->input('id');
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

        $data = [
            'name' => $this->request()->input('name'),
            'price' => $this->request()->input('price'),
            'category' => $this->request()->input('category'),
            'description' => $this->request()->input('description')
        ];

        $this->getDatabase()->update('Service', $data, ['id' => $id]);

        $payload = [
            'action_name' => 'Редактирование услуги',
            'actor_id' => $this->getAuth()->getUser()->id(),
            'action_info' => [
                'Услуга' => $this->request()->input('name'),
                'Цена' => $this->request()->input('price'),
                'Категория' => $this->request()->input('category'),
                'Описание' => $this->request()->input('description'),
                'Пользователь' => $this->getAuth()->getRole()->name() . " " . 
                                $this->getAuth()->getUser()->username() . " " . 
                                $this->getAuth()->getUser()->lastname()
            ]
        ];
        $event = new LogActionEvent($payload);
        $this->getEventManager()->dispatch($event);

        $this->redirect('/admin/dashboard/goods_and_services');
    }

    public function deleteService()
    {
        ob_start(); // Начать буферизацию вывода
        header('Content-Type: application/json'); // Установить заголовок JSON
        try {
            // Получить и залогировать сырое тело запроса
            $rawInput = file_get_contents('php://input');
            error_log('deleteService raw input: ' . $rawInput);

            // Декодировать JSON
            $input = json_decode($rawInput, true);
            $id = $input['id'] ?? null;

            if (!$id) {
                error_log('deleteService: ID not provided');
                echo json_encode(['status' => 'error', 'message' => 'ID услуги не указан']);
                ob_end_flush();
                return;
            }

            error_log('deleteService: Processing ID ' . $id);

            // Проверка существования услуги
            $service = $this->getDatabase()->first_found_in_db('Service', ['id' => $id]);
            if (!$service) {
                error_log('deleteService: Service ID ' . $id . ' not found');
                echo json_encode(['status' => 'error', 'message' => 'Услуга не найдена']);
                ob_end_flush();
                return;
            }

            // Удаление связанных записей в Service_Sale
            $this->getDatabase()->delete('Service_Sale', ['service_id' => $id]);
            error_log('deleteService: Deleted related Service_Sale for ID ' . $id);

            // Удаление услуги
            $result = $this->getDatabase()->delete('Service', ['id' => $id]);
            if ($result === false) {
                throw new Exception('Не удалось удалить услугу');
            }
            error_log('deleteService: Successfully deleted service ID ' . $id);

            // Логирование действия
            $this->getEventManager()->addListener('log.action', new LogActionListener());
            $payload = [
                'action_name' => 'Удаление услуги',
                'actor_id' => $this->getAuth()->getUser()->id(),
                'action_info' => [
                    'Услуга' => $service['name'],
                    'Пользователь' => $this->getAuth()->getRole()->name() . " " . 
                                    $this->getAuth()->getUser()->username() . " " . 
                                    $this->getAuth()->getUser()->lastname()
                ]
            ];
            $event = new LogActionEvent($payload);
            $this->getEventManager()->dispatch($event);

            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            error_log('deleteService error for ID ' . ($id ?? 'unknown') . ': ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Ошибка при удалении услуги: ' . $e->getMessage()]);
        }
        ob_end_flush();
    }

    
}
