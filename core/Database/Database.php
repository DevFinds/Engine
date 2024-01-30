<?php


namespace Core\Database;

use PDO;

class Database implements DatabaseInterface
{

    private PDO $pdo;

    public function insert(string $table, array $data): int|false
    {
    }

    private function connect()
    {
        $pdo = new \PDO("mysql:host=localhost;port=3306;db=shapesider;charset=utf8", 'root', 'root');
    }
}
