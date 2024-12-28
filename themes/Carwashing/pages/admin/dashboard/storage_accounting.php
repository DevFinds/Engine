<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 */

$user = $this->auth->getUser();
$products_OOO = $data['products']->getAllFromDB(1);
$products_IP = $data['products']->getAllFromDB(2);
$suppliers = $data['suppliers']->getAllFromDB();
?>

<?php $render->component('dashboard_header'); ?>
<!-- Сайдбар с меню -->
<?php $render->component('menu_sidebar'); ?>
<!-- Тело страницы -->
<!-- Контейнер с содержимым страницы -->
<div class="page-content-container">
    <!-- Содержимое страницы -->
    <div class="page-content">

        <?php $render->component('pagecontent_header'); ?>


        <!-- Содержимое страницы -->
        <div class=page-content-body>

            <div class="tabs-container">

                <div class="tabs">
                    <div class="tab active" data-tab="warehouseOOO" onclick="switchTab('warehouseOOO')">Склад ООО</div>
                    <div class="tab" data-tab="warehouseIP" onclick="switchTab('warehouseIP')">Склад ИП</div>
                </div>
            </div>


            <div id="warehouseOOOContainer" class="tab-content">
                <div class="warehouseOOO-tab-container">
                    <div class="warehouse-forms-container">
                        <ul class="warehouse-first-column">

                            
                            <li><label class="warehouse-list-label">Список товаров</label></li>
                            <li>
                                <div class="warehouse-list">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Товар</th>
                                                <th>Кол-во</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Таьблица склада ООО -->
                                            <?php foreach ($products_OOO as $product_array => $product): ?>
                                                <tr>
                                                    <td><?php echo $product['id']; ?></td>
                                                    <td><?php echo $product['name']; ?></td>
                                                    <td><?php echo $product['amount']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                            <div class="warehouse-move-label"><label>Переместить из склада</label></div>
                            <button class="warehouse-button">Переместить на склад ИП</button>
                        </ul>




                        <ul class="warehouse-second-column">
                            <li class="warehouse-income-form-container">
                                <label class="warehouse-form-label">Поступление товара на склад ООО</label>
                                <form action="" class="warehouse-income-form">
                                    <select class="warehouse-form-select">
                                        <option disabled selected>Поставщик</option>
                                        <?php foreach ($suppliers as $supplier) : ?>
                                            <option value="<?= $supplier->id() ?>"><?= $supplier->name() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select class="warehouse-form-select">
                                        <option disabled selected>Товар</option>
                                        <?php foreach ($products_OOO as $product_array => $product) : ?>
                                            <option value="<?php echo $product['id']; ?>"> <?php echo $product['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="number" placeholder="Количество">
                                    <input type="date">
                                    <div class="warehouse-form-button-container">
                                        <button type="submit" class="warehouse-form-button">Сохранить</button>
                                        <button type="button" class="warehouse-form-button cancel">Отменить</button>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="warehouseIPContainer" class="tab-content">
                <div class="warehouseIP-tab-container">
                    <div class="warehouse-forms-container">
                        <ul class="warehouse-first-column">
                            <li><label class="warehouse-list-label">Список товаров</label></li>
                            <li>
                                <!-- Таьблица склада ИП -->
                                <div class="warehouse-list">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Товар</th>
                                                <th>Кол-во</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($products_IP as $product_array => $product): ?>
                                                <tr>
                                                    <td><?php echo $product['id']; ?></td>
                                                    <td><?php echo $product['name']; ?></td>
                                                    <td><?php echo $product['amount']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                            <div class="warehouse-move-label"><label>Переместить из склада</label></div>
                            <button class="warehouse-button">Переместить на склад ООО</button>
                        </ul>

                        <ul class="warehouse-second-column">
                            <li class="warehouse-income-form-container">
                                <label class="warehouse-form-label">Поступление товара на склад ИП</label>
                                <form action="" class="warehouse-income-form">
                                    <select class="warehouse-form-select">
                                        <option disabled selected>Поставщик</option>
                                        <?php foreach ($suppliers as $supplier) : ?>
                                            <option value="<?= $supplier->id() ?>"><?= $supplier->name() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select class="warehouse-form-select">
                                        <option disabled selected>Товар</option>
                                        <?php foreach ($products_IP as $product_array => $product) : ?>
                                            <option value="<?php echo $product['id']; ?>"> <?php echo $product['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="number" placeholder="Количество">
                                    <input type="date">
                                    <div class="warehouse-form-button-container">
                                        <button type="submit" class="warehouse-form-button">Сохранить</button>
                                        <button type="button" class="warehouse-form-button cancel">Отменить</button>
                                    </div>
                                </form>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php $render->component('dashboard_footer'); ?>