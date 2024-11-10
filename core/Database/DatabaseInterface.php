<?php


namespace Core\Database;

interface DatabaseInterface
{
    public function insert(string $table, array $data): int|false;
    public function execute(string $sql): void;
    public function first_found_in_db(string $table, array $conditions = []): ?array;
    public function get(string $table, array $conditions = []): ?array;
    public function getTables(): array;
    public function getTableColumns(string $tableName): array;
    public function update(string $table, array $data, array $conditions = []): bool;
    public function createTable(string $tableName, array $columns): bool;
    public function addColumn(string $tableName, string $columnName, string $columnType, string $options = ''): bool;
    public function modifyColumn(string $tableName, string $columnName, string $columnType, string $options = ''): bool;
    public function dropColumn(string $tableName, string $columnName): bool;
    public function dropTable(string $tableName): bool;
    public function isTableExists(string $table): bool;
    public function isColumnExists(string $table, string $column): bool;
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;
}
