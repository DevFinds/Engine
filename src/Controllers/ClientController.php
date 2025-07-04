<?php

namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\ClientService;
use Source\Events\LogActionEvent;
use Source\Listeners\LogActionListener;

class ClientController extends Controller
{
    public function index()
    {
        $service = new ClientService($this->getDatabase());
        $clients = $service->getAllWithCars();
        $this->render('admin/dashboard/client_managments', [
            'clients' => $clients
        ]);
    }

    /**
     * Получить данные клиента по id (AJAX)
     */
    public function getClient($id)
    {
        $service = new ClientService($this->getDatabase());
        $client = $service->getByIdWithCars($id);
        if ($client) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'client' => $client]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Клиент не найден']);
        }
        exit;
    }

    /**
     * Редактировать клиента и его машины (AJAX)
     */
    public function editClient()
    {
        $service = new ClientService($this->getDatabase());
        $id = $_POST['id'] ?? null;
        if (empty($id)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'ID клиента не передан']);
            exit;
        }
        $last_name = $_POST['last_name'] ?? '';
        $first_name = $_POST['first_name'] ?? '';
        $patronymic = $_POST['patronymic'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $car_state_numbers = $_POST['car_state_number'] ?? [];
        $car_brands = $_POST['car_brand'] ?? [];
        $result = $service->updateClientWithCars($id, $last_name, $first_name, $patronymic, $phone, $car_state_numbers, $car_brands);
        header('Content-Type: application/json');
        if ($result === false) {
            if (count($car_state_numbers) !== count(array_unique($car_state_numbers))) {
                echo json_encode(['success' => false, 'message' => 'У клиента не может быть две машины с одинаковым номером!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Клиент с таким номером телефона уже существует']);
            }
        } else {
            // Логирование действия
            $this->getEventManager()->addListener('log.action', new LogActionListener());
            $payload = [
                'action_name' => 'Редактирование клиента',
                'actor_id' => $this->getAuth()->getUser()->id(),
                'action_info' => [
                    'ID' => $id,
                    'Фамилия' => $last_name,
                    'Имя' => $first_name,
                    'Отчество' => $patronymic,
                    'Телефон' => $phone,
                    'Машины' => implode(", ", array_map(function($n, $b){return $n.' ('.$b.')';}, $car_state_numbers, $car_brands)),
                    'Пользователь' => $this->getAuth()->getRole()->name() . " " . $this->getAuth()->getUser()->username() . " " . $this->getAuth()->getUser()->lastname()
                ]
            ];
            $event = new LogActionEvent($payload);
            $this->getEventManager()->dispatch($event);
            echo json_encode(['success' => true]);
        }
        exit;
    }

    /**
     * Удалить клиента и его машины (AJAX)
     */
    public function deleteClient()
    {
        $service = new ClientService($this->getDatabase());
        $id = $_POST['id'] ?? null;
        $result = $service->deleteClient($id);
        header('Content-Type: application/json');
        if ($result) {
            // Логирование действия
            $this->getEventManager()->addListener('log.action', new LogActionListener());
            $payload = [
                'action_name' => 'Удаление клиента',
                'actor_id' => $this->getAuth()->getUser()->id(),
                'action_info' => [
                    'ID' => $id,
                    'Пользователь' => $this->getAuth()->getRole()->name() . " " . $this->getAuth()->getUser()->username() . " " . $this->getAuth()->getUser()->lastname()
                ]
            ];
            $event = new LogActionEvent($payload);
            $this->getEventManager()->dispatch($event);
        }
        echo json_encode(['success' => $result]);
        exit;
    }

    /**
     * Добавить нового клиента с машинами (AJAX)
     */
    public function addClient()
    {
        $service = new ClientService($this->getDatabase());
        $last_name = $_POST['last_name'] ?? '';
        $first_name = $_POST['first_name'] ?? '';
        $patronymic = $_POST['patronymic'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $car_state_numbers = $_POST['car_state_number'] ?? [];
        $car_brands = $_POST['car_brand'] ?? [];
        $result = $service->addClientWithCars($last_name, $first_name, $patronymic, $phone, $car_state_numbers, $car_brands);
        header('Content-Type: application/json');
        if ($result === false) {
            if (count($car_state_numbers) !== count(array_unique($car_state_numbers))) {
                echo json_encode(['success' => false, 'message' => 'У клиента не может быть две машины с одинаковым номером!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Клиент с таким номером телефона уже существует']);
            }
        } else {
            // Логирование действия
            $this->getEventManager()->addListener('log.action', new LogActionListener());
            $payload = [
                'action_name' => 'Добавление клиента',
                'actor_id' => $this->getAuth()->getUser()->id(),
                'action_info' => [
                    'Фамилия' => $last_name,
                    'Имя' => $first_name,
                    'Отчество' => $patronymic,
                    'Телефон' => $phone,
                    'Машины' => implode(", ", array_map(function($n, $b){return $n.' ('.$b.')';}, $car_state_numbers, $car_brands)),
                    'Пользователь' => $this->getAuth()->getRole()->name() . " " . $this->getAuth()->getUser()->username() . " " . $this->getAuth()->getUser()->lastname()
                ]
            ];
            $event = new LogActionEvent($payload);
            $this->getEventManager()->dispatch($event);
            echo json_encode(['success' => true]);
        }
        exit;
    }
} 