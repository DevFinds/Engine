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
                <div class="goods-form-section">
                    <div class="goods-form-main-fields">
                        <label for="" class="goods-form-main-fields-label">Основные поля</label>
                        <div class="goods-form-main-fields-inputs">
                            <ul class="goods-form-main-fields-column">
                                <li><input type="number" placeholder="ID"></li>
                                <li><input type="text" placeholder="Наименование товара"></li>
                            </ul>
                            <ul class="goods-form-main-fields-column">
                                <li><input type="date" placeholder="Дата добавления"></li>
                                <li>
                                    <select class="goods-form-unit-measurement-select" aria-placeholder="Ед. изм.">
                                        <option disabled selected>Ед. изм.</option>
                                        <option disabled selected>Ед. изм.</option>
                                        <option disabled selected>Шт.</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="goods-form-buy-and-sell-fields">
                        <label for="" class="goods-form-buy-and-sell-fields-label">Закупка и продажа</label>
                        <div class="goods-form-buy-and-sell-fields-inputs">
                            <li><input type="number" placeholder="Стоимость закупки"></li>
                            <li><input type="number" placeholder="Стоимость продажи"></li>
                        </div>
                    </div>
                    <div class="goods-form-information">
                        <label for="" class="goods-form-information-label">Информация о поставщике</label>
                        <div class="goods-form-information-selects">
                            <li>
                                <select class="goods-form-provider-select" aria-placeholder="Поставщик">
                                    <option disabled selected>ООО "Компания1"</option>
                                    <option disabled selected>ООО "Компания2"</option>
                                    <option disabled selected>ООО "Компания3"</option>
                                </select>
                            </li>
                            <li>
                                <select class="goods-form-storage-select" aria-placeholder="">
                                    <option disabled selected>ООО "Склад ООО"</option>
                                    <option disabled selected>ООО "Склад ИП"</option>
                                </select>
                            </li>
                        </div>
                        <div class="goods-form-note-section">
                            <button class="goods-form-note-button" onclick="toggleNoteField('note-field-goods-and-services')">Добавить примечание</button>
                            <div class="goods-form-note-container" id="note-field-goods-and-services">
                                <textarea class="goods-form-note-area" placeholder="Введите комментарий"></textarea>
                            </div>
                        </div>
                        <div class="goods-form-buttons">
                            <button class="goods-form-button-save">Сохранить</button>
                            <button class="goods-form-button-clear">Очистить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $render->component('dashboard_footer'); ?>