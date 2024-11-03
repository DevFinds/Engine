<?php

namespace Source\Controllers;

use Core\Controller\Controller;
use Core\Database\DatabaseInterface;
use Core\http\RequestInterface;
use Core\Session\SessionInterface;

class DatabaseController extends Controller
{
    private DatabaseManager $dbManager;
    private RenderInterface $render;

    public function __construct(DatabaseManager $dbManager, RenderInterface $render)
    {
        $this->dbManager = $dbManager;
        $this->render = $render;
    }

    // Просмотр списка таблиц
    public function index(Request $request): Response
    {
        $tables = $this->dbManager->getTables();
        return new Response($this->render->page('admin.database.index', compact('tables')));
    }

    // Создание новой таблицы
    public function createTable(Request $request): Response
    {
        if ($request->isPost()) {
            $tableName = $request->getBodyParam('table_name');
            $columns = $request->getBodyParam('columns');
            
            $this->dbManager->createTable($tableName, $columns);
            return new Response(redirect('/admin/database'), 303);
        }

        return new Response($this->render->page('admin.database.create_table'));
    }

    // Добавление нового столбца в таблицу
    public function addColumn(Request $request): Response
    {
        if ($request->isPost()) {
            $tableName = $request->getBodyParam('table_name');
            $columnName = $request->getBodyParam('column_name');
            $columnType = $request->getBodyParam('column_type');
            $options = $request->getBodyParam('options', '');

            $this->dbManager->addColumn($tableName, $columnName, $columnType, $options);
            return new Response(redirect("/admin/database/{$tableName}/edit"), 303);
        }

        return new Response($this->render->page('admin.database.add_column'));
    }

    // Удаление столбца из таблицы
    public function dropColumn(Request $request): Response
    {
        if ($request->isPost()) {
            $tableName = $request->getBodyParam('table_name');
            $columnName = $request->getBodyParam('column_name');

            $this->dbManager->dropColumn($tableName, $columnName);
            return new Response(redirect("/admin/database/{$tableName}/edit"), 303);
        }

        return new Response($this->render->page('admin.database.drop_column'));
    }

    // Удаление таблицы
    public function dropTable(Request $request): Response
    {
        if ($request->isPost()) {
            $tableName = $request->getBodyParam('table_name');

            $this->dbManager->dropTable($tableName);
            return new Response(redirect('/admin/database'), 303);
        }

        return new Response($this->render->page('admin.database.drop_table'));
    }
}

?>