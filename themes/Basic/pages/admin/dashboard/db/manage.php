/**
 * @var \Core\Render $render
 * @var ConfigInterface $config
 */


?>
<?php $render->component('dashboard_header'); 



?>
<div class="dashboard-bottom-section">
    <div class="container mt-5">
        <h1 class="mb-4">Database Management</h1>

        <!-- Таблица с существующими таблицами -->
        <div class="card mb-4">
            <div class="card-header">Existing Tables</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($tables as $table): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($table) ?>
                            <div>
                                <a href="/admin/database/<?= urlencode($table) ?>/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="/admin/database/drop-table" method="post" class="d-inline-block">
                                    <input type="hidden" name="table_name" value="<?= htmlspecialchars($table) ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Форма создания новой таблицы -->
        <div class="card">
            <div class="card-header">Create New Table</div>
            <div class="card-body">
                <form action="/admin/database/create-table" method="post" id="createTableForm">
                    <div class="mb-3">
                        <label for="tableName" class="form-label">Table Name</label>
                        <input type="text" class="form-control" id="tableName" name="table_name" required>
                    </div>
                    <div id="columnsContainer">
                        <div class="row mb-3">
                            <div class="col">
                                <label>Column Name</label>
                                <input type="text" name="columns[0][name]" class="form-control" required>
                            </div>
                            <div class="col">
                                <label>Column Type</label>
                                <input type="text" name="columns[0][type]" class="form-control" required>
                            </div>
                            <div class="col">
                                <label>Options</label>
                                <input type="text" name="columns[0][options]" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="addColumn()">Add Column</button>
                    <button type="submit" class="btn btn-primary">Create Table</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS и скрипт для добавления столбцов -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-QX6QA0ZqZw7SCK/0RCo4Gr9TczzmM6h+geXG1tAoY+XO9Pp2p10zMGXnxP06DUlg" crossorigin="anonymous"></script>
    <script>
        let columnIndex = 1;

        function addColumn() {
            const container = document.getElementById('columnsContainer');
            const row = document.createElement('div');
            row.classList.add('row', 'mb-3');
            row.innerHTML = `
                <div class="col">
                    <label>Column Name</label>
                    <input type="text" name="columns[${columnIndex}][name]" class="form-control" required>
                </div>
                <div class="col">
                    <label>Column Type</label>
                    <input type="text" name="columns[${columnIndex}][type]" class="form-control" required>
                </div>
                <div class="col">
                    <label>Options</label>
                    <input type="text" name="columns[${columnIndex}][options]" class="form-control">
                </div>
            `;
            container.appendChild(row);
            columnIndex++;
        }
    </script>

<?php $render->component('dashboard_footer'); ?>
