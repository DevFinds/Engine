<?php

namespace Core\Database;

use Core\Config\ConfigInterface;

class DatabaseBuilder implements DatabaseBuilderInterface
{
    private Database $database;

    public function __construct(ConfigInterface $config)
    {
        $this->database = new Database($config);
    }

    public function create_all_tables_from_json(string $jsonFilePath): void
    {
        $schema = $this->loadSchemaFromJson($jsonFilePath);
        $this->create_all_tables_from_schema($schema);
    }

    public function rebuild_database_from_json(string $jsonFilePath): void
    {
        $schema = $this->loadSchemaFromJson($jsonFilePath);
        $this->drop_all_tables($schema);
        $this->create_all_tables_from_schema($schema);
    }

    public function add_new_table_to_database_from_json(string $jsonFilePath): void
    {
        $schema = $this->loadSchemaFromJson($jsonFilePath);
        $this->add_new_table_to_database_from_schema($schema);
    }

    private function create_all_tables_from_schema(array $schema): void
    {
        foreach ($schema as $tableName => $tableSchema) {
            $this->createTable($tableName, $tableSchema);
        }
    }

    private function add_new_table_to_database_from_schema(array $schema): void
    {
        foreach ($schema as $tableName => $tableSchema) {
            if (!$this->database->isTableExists($tableName)) {
                $this->createTable($tableName, $tableSchema);
            }
        }
    }

    private function createTable(string $tableName, array $tableSchema): void
    {
        $columns = [];
        foreach ($tableSchema['columns'] as $columnName => $definition) {
            $columns[] = "`$columnName` $definition";
        }

        $columnsSql = implode(", ", $columns);

        $indexes = [];
        if (isset($tableSchema['indexes'])) {
            foreach ($tableSchema['indexes'] as $index) {
                $indexes[] = $index;
            }
        }

        $indexesSql = implode(", ", $indexes);

        $relationships = [];
        if (isset($tableSchema['relationships'])) {
            foreach ($tableSchema['relationships'] as $relationship) {
                $relationships[] = $this->buildRelationship($relationship);
            }
        }

        $relationshipsSql = implode(", ", $relationships);

        $sql = "CREATE TABLE IF NOT EXISTS `$tableName` ($columnsSql";
        if (!empty($indexesSql)) {
            $sql .= ", $indexesSql";
        }
        if (!empty($relationshipsSql)) {
            $sql .= ", $relationshipsSql";
        }
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $this->database->pdo->exec($sql);
    }

    private function drop_all_tables(array $schema): void
    {
        foreach (array_keys($schema) as $tableName) {
            $sql = "DROP TABLE IF EXISTS `$tableName`;";
            $this->database->pdo->exec($sql);
        }
    }

    private function loadSchemaFromJson(string $jsonFilePath): array
    {
        $json = file_get_contents($jsonFilePath);
        return json_decode($json, true);
    }

    private function buildRelationship(array $relationship): string
    {
        $type = $relationship['type'];
        $columns = implode(", ", array_map(fn ($col) => "`$col`", $relationship['columns']));
        $refTable = $relationship['references']['table'];
        $refColumns = implode(", ", array_map(fn ($col) => "`$col`", $relationship['references']['columns']));
        $onDelete = isset($relationship['on_delete']) ? " ON DELETE " . $relationship['on_delete'] : "";
        $onUpdate = isset($relationship['on_update']) ? " ON UPDATE " . $relationship['on_update'] : "";

        return "$type ($columns) REFERENCES `$refTable` ($refColumns)$onDelete$onUpdate";
    }
}
