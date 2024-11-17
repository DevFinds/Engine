<?php

/**
 * @var \Core\Render $render
 * @var ConfigInterface $config
 */

$user = $this->auth->getUser();
?>
<?php $render->component('dashboard_header');?>
<?php $render->component('menu_sidebar'); ?>
<!-- Тело страницы -->
        <!-- Контейнер с содержимым страницы -->
        <div class="page-content-container">
            <!-- Содержимое страницы -->
            <div class="page-content">

                <!-- Header страницы -->
                <div class="page-content-header">

                    <!-- Хлебные крошки -->
                    <div class="breadcrumbs-container">
                        <a href="" class="breadcrumb-previous">Страницы</a>
                        <span class="breadcrumb-separator">/</span>
                        <a href="" class="breadcrumb-current">Настройки</a>
                    </div>

                    <!-- Пользователь -->
                    <div class="user-container">
                        <img src="<?php echo $user->avatar() ?>" class="user-avatar" alt="">
                        <span class="username"><?php echo $user->username(); ?> <?php echo $user->lastname(); ?></span>
                        <svg class="user-menu-icon" width="10" height="6" viewBox="0 0 10 6" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            
                    </div>
                </div>


                <!-- Содержимое страницы -->
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
                        <td><?= htmlspecialchars($route->getAction()['method']) ?></td>
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
            </div>
        </div>
<?php $render->component('dashboard_footer'); ?>