<?php

/**
 * @var \Core\Render $render
 * @var ConfigInterface $config
 */

 $mysqlDataTypes = [
     'INT',
     'VARCHAR(255)',
     'TEXT',
     'DATE',
     'DATETIME',
     'TIMESTAMP',
     'FLOAT',
     'DOUBLE',
     'DECIMAL(10,2)',
     'CHAR(1)',
     'BOOLEAN',
     // Добавьте другие типы по мере необходимости
 ];
 ?>
 



<?php $render->component('dashboard_header');



?>
<div class="dashboard-bottom-section">
    <div class="dashboard-div-first mt-5">
        <h1 class="mb-4">Управление базой данных</h1>

        <!-- Таблица с существующими таблицами -->
        <div class="card mb-4">
            <div class="card-header">Существующие таблицы</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($tables as $table): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($table) ?>
                            <div>
                                <a href="/admin/dashboard/db/edit/<?= urlencode($table) ?>" class="btn btn-sm btn-outline-primary">Редактировать</a>
                                <form action="/admin/dashboard/db/drop-table" method="post" class="d-inline-block">
                                    <input type="hidden" name="table_name" value="<?= htmlspecialchars($table) ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Удалить</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Форма создания новой таблицы -->
<div class="dashboard-div-second card">
    <div class="card-header" style="margin-bottom: 20px; margin-top: 20px;">Создать новую таблицу</div>
    <div class="card-body">
        <form action="/admin/dashboard/db/createTable" method="post" id="createTableForm">
            <div class="mb-3">
                <label for="tableName" class="form-label">Имя таблицы</label>
                <input type="text" class="form-control" id="tableName" name="table_name" required>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Название колонки</th>
                        <th>Тип колонки</th>
                        <th>Null</th>
                        <th>Ключ</th>
                        <th>По умолчанию</th>
                        <th>Extra</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody id="columnsContainer">
                    <tr>
                        <td>
                            <input type="text" name="columns[0][name]" class="form-control" required>
                        </td>
                        <td>
                            <select name="columns[0][type]" class="form-control">
                                <?php foreach ($mysqlDataTypes as $dataType): ?>
                                    <option value="<?= $dataType ?>"><?= $dataType ?></option>
                                <?php endforeach; ?>
                                <option value="OTHER">Другое</option>
                            </select>
                            <div class="custom-type-container"></div>
                        </td>
                        <td>
                            <select name="columns[0][null]" class="form-control">
                                <option value="NOT NULL">NO</option>
                                <option value="NULL">YES</option>
                            </select>
                        </td>
                        <td>
                            <select name="columns[0][key]" class="form-control">
                                <option value="">-</option>
                                <option value="PRIMARY KEY">PRIMARY</option>
                                <option value="UNIQUE">UNIQUE</option>
                                <option value="INDEX">INDEX</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="columns[0][default]" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="columns[0][extra]" class="form-control">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteColumn(this)">Удалить</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-secondary" onclick="addColumn()">Добавить колонку</button>
            <button type="submit" class="btn btn-primary">Создать таблицу</button>
        </form>
    </div>
</div>

<!-- Отображение ошибок -->
<?php if (!empty($data['errors'])): ?>
    <div class="alert alert-danger">
        <?php foreach ($data['errors'] as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

    </div>

    <!-- Bootstrap JS и скрипт для добавления столбцов -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-QX6QA0ZqZw7SCK/0RCo4Gr9TczzmM6h+geXG1tAoY+XO9Pp2p10zMGXnxP06DUlg" crossorigin="anonymous"></script>
    <script>
    let columnIndex = 1;

    function addColumn() {
        const container = document.getElementById('columnsContainer');
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>
                <input type="text" name="columns[${columnIndex}][name]" class="form-control" required>
            </td>
            <td>
                <select name="columns[${columnIndex}][type]" class="form-control" onchange="checkCustomType(this, ${columnIndex})">
                    <?php foreach ($mysqlDataTypes as $dataType): ?>
                        <option value="<?= $dataType ?>"><?= $dataType ?></option>
                    <?php endforeach; ?>
                    <option value="OTHER">Другое</option>
                </select>
                <div id="customTypeContainer_${columnIndex}" class="custom-type-container"></div>
            </td>
            <td>
                <select name="columns[${columnIndex}][null]" class="form-control">
                    <option value="NOT NULL">NO</option>
                    <option value="NULL">YES</option>
                </select>
            </td>
            <td>
                <select name="columns[${columnIndex}][key]" class="form-control">
                    <option value="">-</option>
                    <option value="PRIMARY KEY">PRIMARY</option>
                    <option value="UNIQUE">UNIQUE</option>
                    <option value="INDEX">INDEX</option>
                </select>
            </td>
            <td>
                <input type="text" name="columns[${columnIndex}][default]" class="form-control">
            </td>
            <td>
                <input type="text" name="columns[${columnIndex}][extra]" class="form-control">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="deleteColumn(this)">Удалить</button>
            </td>
        `;
        container.appendChild(row);
        columnIndex++;
    }

    function deleteColumn(button) {
        const row = button.closest('tr');
        row.remove();
    }

    function checkCustomType(selectElement, index) {
        const selectedValue = selectElement.value;
        const containerId = `customTypeContainer_${index}`;
        let container = document.getElementById(containerId);

        if (selectedValue === 'OTHER') {
            if (!container) {
                const input = document.createElement('input');
                input.type = 'text';
                input.name = `columns[${index}][custom_type]`;
                input.className = 'form-control mt-2';
                input.placeholder = 'Введите тип данных';

                container = document.createElement('div');
                container.id = containerId;
                container.appendChild(input);

                selectElement.parentNode.appendChild(container);
            }
        } else {
            if (container) {
                container.remove();
            }
        }
    }
</script>


    <?php $render->component('dashboard_footer'); ?>