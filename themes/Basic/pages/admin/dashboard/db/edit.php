<?php

/**
 * @var \Core\Render $render
 * @var ConfigInterface $config
 */

$tableName = $data['table_name'];

?>
<?php $render->component('dashboard_header'); ?>


<div class="container mt-5">
    <h1>Редактирование таблицы <?= htmlspecialchars($tableName) ?></h1>
    <!-- Форма для отправки изменений -->
    <form action="/admin/database/<?= urlencode($tableName) ?>/edit" method="post">
        <input type="hidden" name="table_name" value="<?= htmlspecialchars($tableName) ?>">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Поле</th>
                <th>Тип</th>
                <th>Null</th>
                <th>Ключ</th>
                <th>По умолчанию</th>
                <th>Extra</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data['table'] as $index => $column): ?>
                <tr>
                    <td>
                        <input type="text" name="columns[<?= $index ?>][Field]" class="form-control" value="<?= htmlspecialchars($column['Field']) ?>">
                    </td>
                    <td>
                        <input type="text" name="columns[<?= $index ?>][Type]" class="form-control" value="<?= htmlspecialchars($column['Type']) ?>">
                    </td>
                    <td>
                        <select name="columns[<?= $index ?>][Null]" class="form-control">
                            <option value="NO" <?= $column['Null'] === 'NO' ? 'selected' : '' ?>>NO</option>
                            <option value="YES" <?= $column['Null'] === 'YES' ? 'selected' : '' ?>>YES</option>
                        </select>
                    </td>
                    <td>
                        <select name="columns[<?= $index ?>][Key]" class="form-control">
                            <option value="" <?= $column['Key'] === '' ? 'selected' : '' ?>>-</option>
                            <option value="PRI" <?= $column['Key'] === 'PRI' ? 'selected' : '' ?>>PRIMARY</option>
                            <option value="UNI" <?= $column['Key'] === 'UNI' ? 'selected' : '' ?>>UNIQUE</option>
                            <option value="MUL" <?= $column['Key'] === 'MUL' ? 'selected' : '' ?>>INDEX</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="columns[<?= $index ?>][Default]" class="form-control" value="<?= htmlspecialchars($column['Default']) ?>">
                    </td>
                    <td>
                        <input type="text" name="columns[<?= $index ?>][Extra]" class="form-control" value="<?= htmlspecialchars($column['Extra']) ?>">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteColumn(this)">Удалить</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <!-- Добавление нового столбца -->
            <tr>
                <td colspan="7">
                    <button type="button" class="btn btn-secondary" onclick="addColumn()">Добавить столбец</button>
                </td>
            </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
    </form>
</div>
<!-- Скрипты -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let columnCount = <?= count($columns) ?>;

    function addColumn() {
        const tbody = document.querySelector('table tbody');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td>
                <input type="text" name="columns[\${columnCount}][Field]" class="form-control" value="">
            </td>
            <td>
                <input type="text" name="columns[\${columnCount}][Type]" class="form-control" value="">
            </td>
            <td>
                <select name="columns[\${columnCount}][Null]" class="form-control">
                    <option value="NO">NO</option>
                    <option value="YES">YES</option>
                </select>
            </td>
            <td>
                <select name="columns[\${columnCount}][Key]" class="form-control">
                    <option value="">-</option>
                    <option value="PRI">PRIMARY</option>
                    <option value="UNI">UNIQUE</option>
                    <option value="MUL">INDEX</option>
                </select>
            </td>
            <td>
                <input type="text" name="columns[\${columnCount}][Default]" class="form-control" value="">
            </td>
            <td>
                <input type="text" name="columns[\${columnCount}][Extra]" class="form-control" value="">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="deleteColumn(this)">Удалить</button>
            </td>
        `;
        tbody.insertBefore(newRow, tbody.lastElementChild);
        columnCount++;
    }

    function deleteColumn(button) {
        const row = button.closest('tr');
        row.remove();
    }
</script>

<?php $render->component('dashboard_footer'); ?>