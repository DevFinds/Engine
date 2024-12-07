<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 */

//  Поставщики
$company_service = $data['company_service'];
$suppliers = $company_service->getCompanyByType(2);

// Склады
$warehouse_service = $data['warehouse_service'];
$warehouses = $warehouse_service->getAllFromDB();

$user = $this->auth->getUser();
?>

<?php $render->component('dashboard_header'); ?>
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
                    <div class="tab active" onclick="showTab('')">Товары</div>
                    <div class="tab" onclick="showTab('')">Услуги</div>
                </div>
            </div>
            <div class="create-goods-container">
                <p>Создать позицию товара</p>
                <form class="goods-form-section" action="/admin/dashboard/goods_and_services/addNewGood" method="post">
                    <div class="goods-form-main-fields">
                        <label for="" class="goods-form-main-fields-label">Основные поля</label>
                        <div class="goods-form-main-fields-inputs">
                            <ul class="goods-form-main-fields-column">
                                <li><input type="text" name="name" placeholder="Наименование товара"></li>
                                <li><input type="text" name="amount" placeholder="Количество"></li>
                            </ul>
                            <ul class="goods-form-main-fields-column">
                                <li><input type="date" name="created_at" placeholder="Дата добавления"></li>
                                <li>
                                    <select class="goods-form-unit-measurement-select" name="unit_measurement">
                                        <option disabled selected>Ед. изм.</option>
                                        <option value="шт.">Шт.</option>
                                        <option value="кг.">Кг.</option>
                                        <option value="л.">Л.</option>
                                        <option value="м.">М.</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="goods-form-buy-and-sell-fields">
                        <label for="" class="goods-form-buy-and-sell-fields-label">Закупка и продажа</label>
                        <div class="goods-form-buy-and-sell-fields-inputs">
                            <li><input type="number" name="purchase_price" placeholder="Стоимость закупки"></li>
                            <li><input type="number" name="sale_price" placeholder="Стоимость продажи"></li>
                        </div>
                    </div>
                    <div class="goods-form-information">
                        <label for="" class="goods-form-information-label">Информация о поставке</label>
                        <div class="goods-form-information-selects">
                            <li>
                                <select class="goods-form-provider-select" name="supplier_id">
                                    <option disabled selected>Поставщик</option>
                                    <?php foreach ($suppliers as $supplier => $supplierData) : ?>
                                        <option value="<?php echo $supplierData['id'] ?>"><?php echo $supplierData['id'] ?> <?= $supplierData['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </li>
                            <li>
                                <select class="goods-form-storage-select" name="warehouse_id">
                                    <option disabled selected>На склад</option>
                                    <?php foreach ($warehouses as $warehouse => $warehouseData) : ?>
                                        <option value="<?= $warehouseData['id'] ?>"><?= $warehouseData['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </li>
                        </div>
                        <div class="goods-form-note-section">
                            <button type="button" class="goods-form-note-button" onclick="toggleNoteField('note-field-goods-and-services')">Добавить примечание</button>
                            <div class="goods-form-note-container" id="note-field-goods-and-services">
                                <textarea class="goods-form-note-area" name="description" placeholder="Введите комментарий"></textarea>
                            </div>
                        </div>
                        <div class="goods-form-buttons">
                            <button type="submit" class="goods-form-button-save">Сохранить</button>
                            <button class="goods-form-button-clear">Очистить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $render->component('dashboard_footer'); ?>