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

            <form id="carWashContainer" action="/admin/dashboard/service_sales/addNewServiceSale" method="post" class="tab-content">
                <div class="about-service-forms">
                    <ul class="about-service-forms-first-column">
                        <li>
                            <label class="about-service-form-label">Услуга</label>
                            <select class="about-service-form" name="service_id">
                                <option disabled selected>Выбрать услугу</option>
                                <?php foreach ($services as $service => $service_model) : ?>
                                    <option value="<?= $service_model->id() ?>"><?= $service_model->name() ?></option>
                                <?php endforeach; ?>
                            </select>
                        </li>
                        <li>
                            <label class="about-service-form-label">Сотрудник</label>
                            <select class="about-service-form" name="employee_id">
                                <option disabled selected>Выбрать сотрудника</option>
                                <?php foreach ($employees as $employee => $employee_model) : ?>
                                    <option value="<?= $employee_model->id() ?>"><?= $employee_model->name() ?></option>
                                <?php endforeach; ?>
                            </select>
                        </li>
                        <li>
                            <label class="about-service-form-label">Скидка</label>
                            <input type="text" placeholder="Ввести промокод" name="discount_code">
                        </li>
                    </ul>
                    <ul class="about-service-forms-second-column">
                        <li>
                            <label class="about-service-form-label">Гос. номер автомобиля</label>
                            <input type="text"
                                name="car_number"
                                placeholder="A000AA00"
                                pattern="[АВЕКМНОРСТУХ]{1}\d{3}[АВЕКМНОРСТУХ]{2}\d{2,3}"
                                title="Введите номер в формате A111AA111 или A111AA111R"
                                required>
                        </li>
                        <li>
                            <label class="about-service-form-label">Модель автомобиля</label>
                            <input type="text" placeholder="Ввести модель" name="car_model">
                        </li>
                        <li>
                            <label class="about-service-form-label">Марка автомобиля</label>
                            <input type="text" placeholder="Ввести марку" name="car_brand">
                        </li>
                    </ul>
                </div>

                <div class="payment-section">
                    <div class="payment-options">
                        <label class="payment-options-label"> Выбрать рассчет</label>
                        <fieldset class="payment-buttons">
                            <input value="cash" name="payment_type" type="radio" class="payment-button active" onclick="togglePayment('cash')">Наличный</input>
                            <input value="card" name="payment_type" type="radio" class="payment-button" onclick="togglePayment('card')">Безналичный</input>
                        </fieldset>
                        <button type="submit" class="save-button">Сохранить</button>
                    </div>
                    <div class="total-amount">
                        <label class="total-amount-label">Итоговая сумма</label>
                        <div class="total-amount-value"> 500 руб</div>
                    </div>
                </div>

            </form>

            <form id="cafeContainer" class="tab-content" action="/admin/dashboard/service_sales/addNewProductSale" method="post" style="display: none;">
                <div class="about-cafe-forms">
                    <div class="about-cafe-forms-first-column">
                        <label class="about-cafe-form-label">Товар</label>
                        <input type="text" placeholder="Введите название товара" name="product_name" required>
                    </div>
                    <div class="about-cafe-forms-second-column">
                        <label class="about-cafe-form-label">Кол-во товара</label>
                        <input type="number" placeholder="Кол-во, шт" name="product_amount" min="1" required>
                    </div>
                </div>

                <div class="payment-section">
                    <div class="payment-options">
                        <label class="payment-options-label">Выбрать рассчет</label>
                        <fieldset class="payment-buttons">
                            <label>
                                <input value="cash" name="payment_type" type="radio" class="payment-button active" onclick="togglePayment('cash')" required> Наличный
                            </label>
                            <label>
                                <input value="card" name="payment_type" type="radio" class="payment-button" onclick="togglePayment('card')"> Безналичный
                            </label>
                        </fieldset>
                        <button type="submit" class="save-button">Сохранить</button>
                    </div>
                    <div class="total-amount">
                        <label class="total-amount-label">Итоговая сумма</label>
                        <div class="total-amount-value">500 руб</div>
                    </div>
                </div>
            </form>



        </div>
    </div>
</div>

<?php $render->component('dashboard_footer'); ?>