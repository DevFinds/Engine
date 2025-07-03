<?php

namespace Source\Services;

use Core\Database\DatabaseInterface;

class ClientService
{
    public function __construct(private DatabaseInterface $db) {}

    /**
     * Получить всех клиентов с их машинами (номера и марки через запятую)
     */
    public function getAllWithCars(): array
    {
        $sql = "SELECT 
            c.id,
            c.last_name,
            c.name AS first_name,
            c.patronymic,
            c.phone,
            GROUP_CONCAT(car.state_number SEPARATOR ', ') AS state_numbers,
            GROUP_CONCAT(car.car_brand SEPARATOR ', ') AS car_brands
        FROM Client c
        LEFT JOIN Client_cars cc ON c.id = cc.client_id
        LEFT JOIN Car car ON cc.car_id = car.id
        GROUP BY c.id";
        return $this->db->query($sql);
    }

    /**
     * Получить одного клиента с его машинами по id
     */
    public function getByIdWithCars($id): ?array
    {
        $sql = "SELECT c.id, c.last_name, c.name AS first_name, c.patronymic, c.phone,
            car.id as car_id, car.state_number, car.car_brand
        FROM Client c
        LEFT JOIN Client_cars cc ON c.id = cc.client_id
        LEFT JOIN Car car ON cc.car_id = car.id
        WHERE c.id = ?";
        $rows = $this->db->query($sql, [$id]);
        if (!$rows) return null;
        $client = [
            'id' => $rows[0]['id'],
            'last_name' => $rows[0]['last_name'],
            'first_name' => $rows[0]['first_name'],
            'patronymic' => $rows[0]['patronymic'],
            'phone' => $rows[0]['phone'],
            'cars' => []
        ];
        foreach ($rows as $row) {
            if ($row['car_id']) {
                $client['cars'][] = [
                    'id' => $row['car_id'],
                    'state_number' => $row['state_number'],
                    'car_brand' => $row['car_brand']
                ];
            }
        }
        return $client;
    }

    /**
     * Обновить клиента и его машины
     */
    public function updateClientWithCars($id, $last_name, $first_name, $patronymic, $phone, $car_state_numbers, $car_brands): bool
    {
        // Проверка уникальности телефона (кроме текущего клиента)
        $exists = $this->db->query("SELECT id FROM Client WHERE phone=? AND id<>?", [$phone, $id]);
        if ($exists && count($exists) > 0) {
            return false; // Такой телефон уже есть
        }
        // Проверка на дубли номеров машин
        if (count($car_state_numbers) !== count(array_unique($car_state_numbers))) {
            return false; // Дубли номеров машин
        }
        $this->db->update('Client', [
            'last_name' => $last_name,
            'name' => $first_name,
            'patronymic' => $patronymic,
            'phone' => $phone
        ], [
            'id' => $id
        ]);
        $this->db->delete('Client_cars', ['client_id' => $id]);
        foreach ($car_state_numbers as $i => $state_number) {
            $car_brand = $car_brands[$i] ?? '';
            $car = $this->db->query("SELECT id FROM Car WHERE state_number=?", [$state_number]);
            if ($car && isset($car[0]['id'])) {
                $car_id = $car[0]['id'];
                $this->db->update('Car', [
                    'car_brand' => $car_brand
                ], [
                    'id' => $car_id
                ]);
            } else {
                $car_id = $this->db->insert('Car', [
                    'state_number' => $state_number,
                    'car_brand' => $car_brand
                ]);
            }
            $this->db->insert('Client_cars', [
                'client_id' => $id,
                'car_id' => $car_id
            ]);
        }
        return true;
    }

    /**
     * Удалить клиента и его связи с машинами
     */
    public function deleteClient($id): bool
    {
        $this->db->delete('Client_cars', ['client_id' => $id]);
        $this->db->delete('Client', ['id' => $id]);
        return true;
    }

    /**
     * Добавить нового клиента с машинами
     */
    public function addClientWithCars($last_name, $first_name, $patronymic, $phone, $car_state_numbers, $car_brands): bool
    {
        // Проверка уникальности телефона
        $exists = $this->db->query("SELECT id FROM Client WHERE phone=?", [$phone]);
        if ($exists && count($exists) > 0) {
            return false; // Такой телефон уже есть
        }
        // Проверка на дубли номеров машин
        if (count($car_state_numbers) !== count(array_unique($car_state_numbers))) {
            return false; // Дубли номеров машин
        }
        $client_id = $this->db->insert('Client', [
            'last_name' => $last_name,
            'name' => $first_name,
            'patronymic' => $patronymic,
            'phone' => $phone
        ]);
        foreach ($car_state_numbers as $i => $state_number) {
            $car_brand = $car_brands[$i] ?? '';
            $car = $this->db->query("SELECT id FROM Car WHERE state_number=?", [$state_number]);
            if ($car && isset($car[0]['id'])) {
                $car_id = $car[0]['id'];
                $this->db->update('Car', [
                    'car_brand' => $car_brand
                ], [
                    'id' => $car_id
                ]);
            } else {
                $car_id = $this->db->insert('Car', [
                    'state_number' => $state_number,
                    'car_brand' => $car_brand
                ]);
            }
            $this->db->insert('Client_cars', [
                'client_id' => $client_id,
                'car_id' => $car_id
            ]);
        }
        return true;
    }
} 