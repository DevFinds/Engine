<?php

namespace Source\Controllers;

use Core\Http\Request;
use Core\Controller\Controller;

class DatabaseController extends Controller
{
    private $db;

    // Отображение страницы управления базой данных
    public function index()
    {

        $this->db = $this->getDatabase();
        // Получаем список таблиц
        $tables = $this->db->getTables();

        $errors = [];

        // Передаем список таблиц в представление
        $this->render('admin/dashboard/db/manage', ['tables' => $tables, 'errors' => $errors]);
    }

    public function editTable($table_name)
    {
        $this->db = $this->getDatabase();
        // Получаем список таблиц
        $tables = $this->db->getTables();
        foreach ($tables as $key => $value) {
            if ($value == $table_name) {
                $table = $this->db->getTableColumns($table_name);
            }
        }

        // Передаем список таблиц в представление
        $this->render('/admin/dashboard/db/edit', ['table' => $table, 'table_name' => $table_name]);
    }

    // Обработка создания новой таблицы
    public function createTable()
    {
        $this->db = $this->getDatabase();
        $tables = $this->db->getTables();
        $errors = [];
        $request = $this->Request();
        if ($request->method() === 'POST') {
            $tableName = $request->input('table_name');
            $columns = $request->input('columns');

            // Обработка и валидация входных данных
            if (empty($tableName) || empty($columns)) {
                array_push($errors, ["Пожалуйста, заполните все поля."]);
                $this->render('admin/dashboard/db/manage', ['errors' => $errors, 'old' => $request->AllInputs()]);
                return;
            }

            if (!$this->isValidName($tableName)) {
                array_push($errors, ["Недопустимое имя таблицы."]);
                $this->render('admin/dashboard/db/manage', ['errors' => $errors, 'old' => $request->AllInputs()]);
                return;
            }

            if ($this->db->isTableExists($tableName)) {
                array_push($errors, ["Таблица с таким именем уже существует."]);
                $this->render('admin/dashboard/db/manage', ['errors' => $errors, 'old' => $request->AllInputs()]);
                return;
            }

            $formattedColumns = [];
            $primaryKeys = [];
            $indexes = [];

            foreach ($columns as $column) {
                $name = $column['name'];
                $type = $column['type'] === 'OTHER' ? $column['custom_type'] : $column['type'];

                if (!$this->isValidName($name)) {
                    array_push($errors, ["Таблица с таким именем уже существует.", "Недопустимое имя столбца."]);
                    $this->render('admin/dashboard/db/manage', ['errors' => $errors, 'old' => $request->AllInputs()]);
                    return;
                }

                $null = isset($column['null']) && $column['null'] === 'NULL' ? 'NULL' : 'NOT NULL';
                $default = isset($column['default']) && $column['default'] !== '' ? "DEFAULT '{$column['default']}'" : '';
                $extra = isset($column['extra']) ? $column['extra'] : '';
                $key = isset($column['key']) ? $column['key'] : '';

                $columnDef = "`$name` $type $null $default $extra";

                if ($key === 'PRIMARY KEY') {
                    $primaryKeys[] = $name;
                } elseif ($key === 'UNIQUE') {
                    $columnDef .= " UNIQUE";
                } elseif ($key === 'INDEX') {
                    $indexes[] = $name;
                }

                $formattedColumns[] = $columnDef;
            }

            if (!empty($primaryKeys)) {
                $formattedColumns[] = "PRIMARY KEY (" . implode(', ', array_map(fn($key) => "`$key`", $primaryKeys)) . ")";
            }

            foreach ($indexes as $index) {
                $formattedColumns[] = "INDEX (`$index`)";
            }

            $columnsSql = implode(", ", $formattedColumns);
            $tableNameEscaped = str_replace('`', '``', $tableName);
            $sql = "CREATE TABLE `{$tableNameEscaped}` ($columnsSql) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

            // Выполнение запроса
            try {
                $this->db->beginTransaction();
                $this->db->execute($sql);
                $this->db->commit();
                $this->redirect('/admin/dashboard/db/manage');
            } catch (\Exception $e) {
                $this->db->rollBack();
                error_log($e->getMessage());
                array_push($errors, ["Таблица с таким именем уже существует.", $e->getMessage()]);
                $this->render('admin/dashboard/db/manage', ['tables' => $tables, 'errors' => $errors]);
            }
        } else {
            $this->redirect('/admin/dashboard/db/manage');
        }
    }

    // Добавьте вспомогательный метод для проверки имени
    private function isValidName($name)
    {
        return preg_match('/^[a-zA-Z0-9_]+$/', $name);
    }


    // Обработка удаления таблицы
    public function dropTable()
    {
        $this->db = $this->getDatabase();
        $errors = [];
        $request = $this->Request();
        if ($request->method() === 'POST') {
            $tableName = $request->input('table_name');

            if (empty($tableName)) {
                $errors = "Имя таблицы не может быть пустым.";
                $this->render('admin/dashboard/db/manage', ['errors' => $errors]);
                return;
            }

            $sql = "DROP TABLE IF EXISTS `$tableName`;";
            try {
                $this->db->execute($sql);
                $this->redirect('/admin/dashboard/db/manage');
            } catch (\Exception $e) {
                $errors = "Ошибка при удалении таблицы: " . $e->getMessage();
                $this->render('admin/dashboard/db/manage', ['errors' => $errors]);
            }
        } else {
            $this->redirect('/admin/dashboard/db/manage');
        }
    }
}
