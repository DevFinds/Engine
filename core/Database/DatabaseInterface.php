<?php


namespace Core\Database;

interface DatabaseInterface
{
    public function insert(string $table, array $data): int|false;
    public function first_found_in_db(string $table, array $conditions = []): ?array;
    public function get(string $table, array $conditions = []): ?array;
}
