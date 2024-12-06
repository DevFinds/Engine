<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 */

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

        <?php $render->component('pagecontent_header'); ?>





        <!-- Содержимое страницы -->
        <div class="user-card">
            <img src="/storage/default/empty_avatar.png" class="accountpage-avatar" alt="">
            <div class="user-card-info">
                <div class="user-card-head">
                    <div>
                        <h1>Роман Стрижов</h1>
                        <form action="">
                            <button type="submit" class="user-card-edit-button"><img src="/assets/themes/Carwashing/img/settings-icon.svg" alt=""></button>
                        </form>
                    </div>
                    <h2>Мойщик</h2>
                </div>
                <div class="user-card-attributes">
                    <div class="user-card-item">
                        <img src="/assets/themes/Carwashing/img/user.svg" alt="">
                        <span>username</span>
                    </div>
                    <div class="user-card-item">
                        <img src="/assets/themes/Carwashing/img/mail.svg" alt="">
                        <span>username@mail.ru</span>
                    </div>
                    <div class="user-card-item">
                        <img src="/assets/themes/Carwashing/img/phone.svg" alt="">
                        <span>+7999999999</span>
                    </div>
                    <div class="user-card-item">
                        <img src="/assets/themes/Carwashing/img/page.svg" alt="">
                        <span>ООО</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="tabs-container">

            <div class="tabs">
                <div class="tab active" data-tab="days" onclick="switchTab('days')">День</div>
                <div class="tab" data-tab="weeks" onclick="switchTab('weeks')">Неделя</div>
                <div class="tab" data-tab="mounths" onclick="switchTab('mounths')">Месяц</div>
            </div>
        </div>

        <div class="tab-content" id="daysContainer">
            <div class="user-stats-container">
                <div class="user-stats">
                    <span>Выполнено услуг</span>
                    <span>39</span>
                </div>
                <div class="user-stats">
                    <span>Суммарная стоимость выполненных услуг</span>
                    <span>10 285₽</span>
                </div>
                <div class="user-stats">
                    <span>Автомобилей обслужено</span>
                    <span>39</span>
                </div>
                <div class="user-stats">
                    <span>Сумма начисленной з/п</span>
                    <span>15 000₽</span>
                </div>
                <div class="user-stats">
                    <span>З/п на основе кол-ва оказанных услуг</span>
                    <span>14 000₽</span>
                </div>
            </div>
        </div>
        <div class="tab-content" id="weeksContainer">
            <div class="user-stats-container">
                <div class="user-stats">
                    <span>Выполнено услуг</span>
                    <span>37</span>
                </div>
                <div class="user-stats">
                    <span>Суммарная стоимость выполненных услуг</span>
                    <span>10 285₽</span>
                </div>
                <div class="user-stats">
                    <span>Автомобилей обслужено</span>
                    <span>39</span>
                </div>
                <div class="user-stats">
                    <span>Сумма начисленной з/п</span>
                    <span>15 000₽</span>
                </div>
                <div class="user-stats">
                    <span>З/п на основе кол-ва оказанных услуг</span>
                    <span>14 000₽</span>
                </div>
            </div>
        </div>
        <div class="tab-content" id="mounthsContainer">
            <div class="user-stats-container">
                <div class="user-stats">
                    <span>Выполнено услуг</span>
                    <span>38</span>
                </div>
                <div class="user-stats">
                    <span>Суммарная стоимость выполненных услуг</span>
                    <span>10 285₽</span>
                </div>
                <div class="user-stats">
                    <span>Автомобилей обслужено</span>
                    <span>39</span>
                </div>
                <div class="user-stats">
                    <span>Сумма начисленной з/п</span>
                    <span>15 000₽</span>
                </div>
                <div class="user-stats">
                    <span>З/п на основе кол-ва оказанных услуг</span>
                    <span>14 000₽</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $render->component('dashboard_footer'); ?>