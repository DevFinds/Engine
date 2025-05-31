<?php
namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\CarClasses;

class CarClassesService
{
    private DatabaseInterface $database;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    public function getAllFromDB(): array
    {
        $results = $this->database->get('Car_Classes');
        $carClasses = [];
        foreach ($results as $result) {
            $carClasses[] = new CarClasses(
                $result['id'],
                $result['name'],
                $result['markup']
            );
        }
        return $carClasses;
    }

    public function getById(int $id): ?CarClasses
    {
        $result = $this->database->first_found_in_db('Car_Classes', ['id' => $id]);
        if ($result) {
            return new CarClasses(
                $result['id'],
                $result['name'],
                $result['markup']
            );
        }
        return null;
    }

    public function add(array $data): bool
    {
        return $this->database->insert('Car_Classes', [
            'name' => $data['name'],
            'markup' => $data['markup']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        return $this->database->update('Car_Classes', [
            'name' => $data['name'],
            'markup' => $data['markup']
        ], ['id' => $id]);
    }

    public function delete(int $id): bool
    {
        return $this->database->delete('Car_Classes', ['id' => $id]);
    }
}