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


    public function beginTransaction(): void
    {
        $this->pdo->beginTransaction();
    }

    public function commit(): void
    {
        $this->pdo->commit();
    }

    public function rollBack(): void
    {
        $this->pdo->rollBack();
    }


    // Метод для добавления записей в таблицы БД
    public function insert(string $table, array $data): int|false
    {
        $fields = array_keys($data);
        $columns = implode(', ', $fields);
        $inserting_data = implode(', ', array_map(fn($field) => ":$field", $fields));

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

    public function update($table, $data, $conditions = []): bool
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

    // Метод для выполнения SQL-запроса
    public function execute(string $sql): void
    {
        $stmt = $this->pdo->prepare($sql);
        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            throw new \Exception($errorInfo[2]);
        }
    }

    public function first_found_in_db(string $table, array $conditions = []): ?array
    {

        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "BINARY $field = :$field", array_keys($conditions)));
        }

        $sql = "SELECT * FROM $table $where LIMIT 1";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($conditions);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function getTables(): array
    {
        $stmt = $this->pdo->query("SHOW TABLES");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getTableColumns(string $tableName): array
    {
        $stmt = $this->pdo->prepare("SHOW COLUMNS FROM `$tableName`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function get(string $table, array $conditions = []): ?array
    {
        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));
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
    }

    public function isTableExists(string $table): bool
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
    public function isColumnExists(string $table, string $column): bool
    {
        $sql = "SELECT $column FROM information_schema.columns WHERE table_name = '$table' AND column_name = '$column'";
        if (!$this->pdo->query($sql)) {
            return false;
        }
        return true;
    }


    public function createTable(string $tableName, array $columns): bool
    {
        $columnsSql = [];
        foreach ($columns as $columnName => $attributes) {
            $columnsSql[] = "`$columnName` {$attributes['type']} {$attributes['options']}";
        }
        $sql = "CREATE TABLE `$tableName` (" . implode(", ", $columnsSql) . ") ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        try {
            $this->pdo->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Error creating table: " . $e->getMessage();
            return false;
        }
    }

    public function addColumn(string $tableName, string $columnName, string $columnType, string $options = ''): bool
    {
        $sql = "ALTER TABLE `$tableName` ADD `$columnName` $columnType $options";
        try {
            $this->pdo->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Error adding column: " . $e->getMessage();
            return false;
        }
    }

    public function modifyColumn(string $tableName, string $columnName, string $columnType, string $options = ''): bool
    {
        $sql = "ALTER TABLE `$tableName` MODIFY `$columnName` $columnType $options";
        try {
            $this->pdo->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Error modifying column: " . $e->getMessage();
            return false;
        }
    }

    public function dropColumn(string $tableName, string $columnName): bool
    {
        $sql = "ALTER TABLE `$tableName` DROP COLUMN `$columnName`";
        try {
            $this->pdo->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Error dropping column: " . $e->getMessage();
            return false;
        }
    }

    public function dropTable(string $tableName): bool
    {
        $sql = "DROP TABLE IF EXISTS `$tableName`";
        try {
            $this->pdo->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Error dropping table: " . $e->getMessage();
            return false;
        }
    }
    public function query(string $sql, array $params = []): array
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit("Error executing query: " . $e->getMessage());
            return [];
        }
    }

    public function delete(string $table, array $conditions): bool
    {
        if (empty($conditions)) {
            throw new Exception("Условия для удаления обязательны");
        }

        // Формируем часть WHERE из условий
        $where = implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));
        $sql = "DELETE FROM $table WHERE $where";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($conditions);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Ошибка удаления из таблицы: " . $e->getMessage());
        }
    }

    /**
     * Проверяет, существуют ли записи в таблице по заданным условиям.
     *
     * @param string $table Имя таблицы
     * @param array $conditions Условия для проверки (ключ => значение)
     * @return bool Возвращает true, если записи найдены, иначе false
     */
    public function exists(string $table, array $conditions): bool
    {
        if (empty($conditions)) {
            error_log("Database::exists - Условия пусты для таблицы $table");
            return false;
        }

        $where = implode(' AND ', array_map(fn($field) => "`$field` = :$field", array_keys($conditions)));
        $sql = "SELECT EXISTS (SELECT 1 FROM `$table` WHERE $where) as `exists`";
        error_log("Database::exists - SQL: $sql, Условия: " . json_encode($conditions));

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($conditions);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log("Database::exists - Результат: " . json_encode($result));
            return (bool) $result['exists'];
        } catch (PDOException $e) {
            error_log("Database::exists - Ошибка: " . $e->getMessage());
            return false;
        }
    }
}
