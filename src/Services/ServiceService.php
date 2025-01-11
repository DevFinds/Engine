<?php


namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\Service;

class ServiceService
{
    public function __construct(
        private DatabaseInterface $db,
    ) {}

    public function getAllFromDB(): array
    {
        $services = $this->db->get('Service');
        $services = array_map(function ($service) {
            return new Service(
                $service['id'],
                $service['name'],
                $service['description'],
                $service['price'],
                $service['category'],
                $service['car_id']
            );
        }, $services);
        return $services;
    }

    public function getAllFromDBAsArray(): array
    {
        $services = $this->db->get('Service');
        return $services;
    }

    public function getServiceById(int $id): ?Service
    {
        $role = $this->db->first_found_in_db('roles', ['id' => $id]);
        return $role;
    }
}
