<?php


namespace Core\Database;

use Core\Config\ConfigInterface;
use Exception;
use PDO;
use PDOException;

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

    public function update($table, $data, $conditions = []) : bool
    {
        // Генерация SQL-запроса для обновления данных
        $updateQuery = "UPDATE $table SET ";

        foreach ($data as $key => $value) {
            $updateQuery .= "$key = :$key, ";
        }
        
        $updateQuery = rtrim($updateQuery, ', ');

        // Добавление условий, если они переданы
        if (!empty($conditions)) {
            $updateQuery .= " WHERE ";

            foreach ($conditions as $key => $value) {
                $updateQuery .= "$key = :$key AND ";
            }

            $updateQuery = rtrim($updateQuery, ' AND ');
        }
        // Подготовка запроса
        $stmt = $this->pdo->prepare($updateQuery);
        
        // Выполнение запроса с передачей параметров
        try {
            $stmt->execute(array_merge($data, $conditions));
        } catch (\PDOException $exception) {
            exit("Ошибка обновления данных в таблице: {$exception->getMessage()}");
            return false;
        }
        return true;
    }

    public function first_found_in_db(string $table, array $conditions = []): ?array
    {

        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn ($field) => "BINARY $field = :$field", array_keys($conditions)));
        }

        $sql = "SELECT * FROM $table $where LIMIT 1";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($conditions);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function get(string $table, array $conditions = []): ?array
    {
        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn ($field) => "$field = :$field", array_keys($conditions)));
        }

        $sql = "SELECT * FROM $table $where";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($conditions);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result ?: null;
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

        if ($this->isTableExists('users') == false) {
            $this->createTable();
        }
    }

    private function isTableExists(string $table): bool
    {
        try {
            $sql = "SELECT 1 FROM $table LIMIT 1";
            $stmt = $this->pdo->query($sql);
            return $stmt !== false;
        } catch (PDOException $e) {
            // Handle the exception, e.g. log it or return false
            return false;
        }
    }
    private function isColumnExists(string $table, string $column): bool
    {
        $sql = "SELECT $column FROM information_schema.columns WHERE table_name = '$table' AND column_name = '$column'";
        if (!$this->pdo->query($sql)) {
            return false;
        }
        return true;
    }

    private function createTable()
    {
        try {
            $sql = "CREATE TABLE `users` (
            `id` int(255) NOT NULL AUTO_INCREMENT,
            `username` varchar(32) DEFAULT NULL,
            `login` varchar(32) DEFAULT NULL,
            `email` varchar(100) DEFAULT NULL,
            `password` varchar(100) DEFAULT NULL)
            ENGINE=InnoDB DEFAULT CHARSET=utf8;
            ALTER TABLE `users`
            ADD PRIMARY KEY (`id`);";
            $this->pdo->exec($sql);
        } catch (PDOException $e) {
            echo "Error creating table: " . $e->getMessage();
        }
    }

    private function createColumn()
    {
        $sql = "ALTER TABLE `users`
          ADD PRIMARY KEY (`id`);";
        $this->pdo->exec($sql);
    }

    
}
