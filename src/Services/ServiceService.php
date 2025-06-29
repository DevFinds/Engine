<?php

namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\Service;
use Source\Models\Car;

class ServiceService
{
    public function __construct(
        private DatabaseInterface $db,
    ) {}

    public function getAllFromDB(): array
    {
        $services = $this->db->get('Service');
        return array_map(function ($service) {
            return new Service(
                $service['id'],
                $service['name'],
                $service['description'],
                $service['price'],
                $service['category']
            );
        }, $services);
    }

    public function getAllFromDBAsArray(): array
    {
        return $this->db->get('Service');
    }

    public function getServiceById(int $id): ?Service
    {
        $service = $this->db->first_found_in_db('Service', ['id' => $id]);
        if (!$service) {
            return null;
        }
        return new Service(
            $service['id'],
            $service['name'],
            $service['description'],
            $service['price'],
            $service['category']
        );
    }

    public function getAllCars(): array
    {
        $cars = $this->db->get('Car');
        return array_map(function ($car) {
            return new Car(
                $car['id'],
                $car['state_number'],
                $car['car_type'],
                $car['car_brand'],
                $car['client_id'],
                $car['car_model'],
                $car['class_id']
            );
        }, $cars);
    }

    public function getAllCarsAsArray(): array
    {
        $cars = $this->db->get('Car');
        return array_map(function ($car) {
            return $car; // Убрали расчет markup
        }, $cars);
    }

    public function getAllClassesAsArray(): array
    {
        return $this->db->get('Car_Classes') ?? [];
    }
}