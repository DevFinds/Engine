<?php


namespace Core\Database;

use Core\Config\ConfigInterface;
use PDO;

class Database implements DatabaseInterface
{

    private PDO $pdo;

    public function __construct(
        private ConfigInterface $config,
    ) {
        $this->connect();
    }

    // Метод для добавления записей в таблицы БД
    public function insert(string $table, array $data): int|false
    {
        $fields = array_keys($data);
        $columns = implode(', ', $fields);
        $inserting_data = implode(', ', array_map(fn ($field) => ":$field", $fields));

        $sql = "INSERT INTO $table ($columns) VALUES ($inserting_data)";
        $statement = $this->pdo->prepare($sql);


        try {
            $statement->execute($data);
        } catch (\PDOException $exception) {
            exit("Ошибка вставки данных в таблицу: {$exception->getMessage()}");
            return false;
        }

        return (int) $this->pdo->lastInsertId();
    }


    private function connect()
    {

        $driver = $this->config->get('database.driver');
        $host = $this->config->get('database.host');
        $port = $this->config->get('database.port');
        $database = $this->config->get('database.database');
        $username = $this->config->get('database.username');
        $password = $this->config->get('database.password');
        $charset = $this->config->get('database.charset');

        try {
            $this->pdo = new PDO("$driver:host=$host;port=$port;dbname=$database;charset=$charset", $username, $password);
        } catch (\PDOException $exception) {
            exit("Ошибка подключения к БД: {$exception->getMessage()}");
        }
    }
}
