<?php
/**
 * @var array $routes Массив маршрутов
 * @var string $errors Ошибки, если есть
 */

//  dd($routes);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление маршрутами</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php $this->component('dashboard_header'); ?>

<div class="container mt-5">
    <h1>Управление маршрутами</h1>

    <!-- Отображение ошибок -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <p><?= htmlspecialchars($errors) ?></p>
        </div>
    <?php endif; ?>

    <!-- Таблица маршрутов -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Метод</th>
                <th>URI</th>
                <th>Контроллер</th>
                <th>Метод контроллера</th>
                <th>Посредники</th>
                <th>Параметры</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($routes as $index => $route): ?>
                <tr>
                    <td><?= htmlspecialchars($route->getMethod()) ?></td>
                    <td><?= htmlspecialchars($route->getUri()) ?></td>
                    <td><?= htmlspecialchars($route->getAction()['controller']) ?></td>
                    <td><?= htmlspecialchars($route->getAction()['method'])?></td>
                    <td>
                        <?php
                        $middlewares = $route->getMiddlewares();
                        if (isset($middlewares)) {
                            echo htmlspecialchars(implode(', ', $middlewares));
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $parameters = $route->getRegular();
                        if (isset($parameters)) {
                            foreach ($parameters as $param => $regex) {
                                echo htmlspecialchars("$param: $regex") . '<br>';
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <a href="/admin/routes/edit/<?= $index ?>" class="btn btn-primary btn-sm">Редактировать</a>
                        <a href="/admin/routes/delete/<?= $index ?>" class="btn btn-danger btn-sm">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Кнопка добавления нового маршрута -->
    <a href="/admin/routes/create" class="btn btn-success">Добавить маршрут</a>
</div>

<?php $this->component('dashboard_footer'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
