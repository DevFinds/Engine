<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 */

$companies = $data['companies'];
$company_types = $data['company_types'];
$user = $this->auth->getUser();
?>

<?php $render->component('dashboard_header'); ?>
<!-- Сайдбар с меню -->
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
                <a href="" class="breadcrumb-current">Товары и услуги</a>
            </div>

            <!-- Пользователь -->
            <div class="user-container">
                <img src="./assets/img/avatar.png" class="user-avatar" alt="">
                <span class="username">Иван Иванов</span>
                <svg class="user-menu-icon" width="10" height="6" viewBox="0 0 10 6" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>

            </div>
        </div>
        <!-- Содержимое страницы -->
        <div class=page-content-body>

            <div class="tabs-container">

                <div class="tabs">
                    <div class="tab active" onclick="showTab('')">Товары</div>
                    <div class="tab" onclick="showTab('')">Услуги</div>
                </div>
            </div>
            <form class="create-goods-container" action="/admin/dashboard/goods_and_services/addNewGood" method="post">
                <p>Создать позицию товара</p>
                <div class="goods-form-section">
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
                                        <option value="test">Шт.</option>
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
                        <label for="" class="goods-form-information-label">Информация о товаре</label>
                        <div class="goods-form-information-selects">
                            <li>
                                <select class="goods-form-provider-select" name="supplier_id">
                                    <option selected value="">Поставщик</option>
                                    <option value="1">ООО "Компания2"</option>
                                    <option value="2">ООО "Компания3"</option>
                                </select>
                            </li>
                            <li>
                                <select class="goods-form-storage-select" name="warehouse_id">
                                    <option selected value="empty">Склад</option>
                                    <option value="1">ООО "Склад ООО"</option>
                                    <option value="2">ООО "Склад ИП"</option>
                                </select>
                            </li>
                        </div>
                        <div class="goods-form-note-section">
                            <button type="button" class="goods-form-note-button" onclick="toggleNoteField('note-field-goods-and-services')">Добавить примечание</button>
                            <div class="goods-form-note-container" id="note-field-goods-and-services">
                                <textarea name="description" class="goods-form-note-area" placeholder="Введите комментарий"></textarea>
                            </div>
                        </div>
                        <div class="goods-form-buttons">
                            <button type="submit" class="goods-form-button-save">Сохранить</button>
                            <button class="goods-form-button-clear">Очистить</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<?php $render->component('dashboard_footer'); ?>