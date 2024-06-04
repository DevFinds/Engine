<?php

namespace Core\Database;

interface DatabaseBuilderInterface
{
    public function create_all_tables_from_json(string $jsonFilePath): void;
    public function rebuild_database_from_json(string $jsonFilePath): void;
    public function add_new_table_to_database_from_json(string $jsonFilePath): void;
}
