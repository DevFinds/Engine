<?php

use \Source\Models\Service;

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 * @var \Source\Models\Service $service
 */

$user = $this->auth->getUser();
$services = $data['service']->getAllFromDB();
$employees = $data['employees']->getAllFromDB();
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
                    <div class="tab active" data-tab="carWash" onclick="switchTab('carWash', 'tabs')">Автомойка</div>
                    <div class="tab" data-tab="cafe" onclick="switchTab('cafe')">Кафе</div>
                </div>
            </div>

            <div id="carWashContainer" class="tab-content">
                <div class="about-service-forms">
                    <ul class="about-service-forms-first-column">
                        <li>
                            <label class="about-service-form-label">Услуга</label>
                            <select class="about-service-form">
                                <option disabled selected>Выбрать услугу</option>
                                <?php foreach ($services as $service => $service_model) : ?>
                                    <option value="<?= $service_model->id() ?>"><?= $service_model->name() ?></option>
                                <?php endforeach; ?>
                            </select>
                        </li>
                        <li>
                            <label class="about-service-form-label">Сотрудник</label>
                            <select class="about-service-form">
                                <option disabled selected>Выбрать сотрудника</option>
                                <?php foreach ($employees as $employee=> $employee_model) : ?>
                                    <option value="<?= $employee_model->id() ?>"><?= $employee_model->name() ?></option>
                                <?php endforeach; ?>
                            </select>
                        </li>
                        <li>
                            <label class="about-service-form-label">Скидка</label>
                            <input type="text" placeholder="Ввести промокод">
                        </li>
                    </ul>
                    <ul class="about-service-forms-second-column">
                        <li>
                            <label class="about-service-form-label">Гос. номер автомобиля</label>
                            <input type="text"
                                placeholder="A000AA00"
                                pattern="[АВЕКМНОРСТУХ]{1}\d{3}[АВЕКМНОРСТУХ]{2}\d{2,3}"
                                title="Введите номер в формате A111AA111 или A111AA111R"
                                required>
                        </li>
                        <li>
                            <label class="about-service-form-label">Модель автомобиля</label>
                            <input type="text" placeholder="Ввести модель">
                        </li>
                        <li>
                            <label class="about-service-form-label">Марка автомобиля</label>
                            <input type="text" placeholder="Ввести марку">
                        </li>
                    </ul>
                </div>
            </div>

            <div id="cafeContainer" class="tab-content" style="display: none;">
                <div class="about-cafe-forms">
                    <div class="about-cafe-forms-first-column">
                        <label class="about-cafe-form-label">Товар</label>
                        <input type="text" placeholder="Выбрать товар">
                    </div>
                    <div class="about-cafe-forms-second-column">
                        <label class="about-cafe-form-label">Кол-во товара</label>
                        <input type="text" placeholder="Кол-во, шт">
                    </div>
                </div>
            </div>
            <div class="payment-section">
                <div class="payment-options">
                    <label class="payment-options-label"> Выбрать рассчет</label>
                    <div class="payment-buttons">
                        <button type="button" class="payment-button active" onclick="togglePayment('cash')">Наличный</button>
                        <button type="button" class="payment-button" onclick="togglePayment('card')">Безналичный</button>
                    </div>
                    <button class="save-button">Сохранить</button>
                </div>
                <div class="total-amount">
                    <label class="total-amount-label">Итоговая сумма</label>
                    <div class="total-amount-value"> 500 руб</div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $render->component('dashboard_footer'); ?>