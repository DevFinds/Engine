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

        <!-- Header страницы -->
        <div class="page-content-header">

            <!-- Хлебные крошки -->
            <div class="breadcrumbs-container">
                <a href="" class="breadcrumb-previous">Страницы</a>
                <span class="breadcrumb-separator">/</span>
                <a href="" class="breadcrumb-current">Управление компанией</a>
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
        <div class="page-content-body">

            <div class="tabs-container">

                <div class="tabs">
                    <div class="tab active" data-tab="about-company" onclick="switchTab('about-company')">О компании</div>
                    <div class="tab" data-tab="employees-list" onclick="switchTab('employees-list')">Сотрудники</div>
                    <div class="tab" data-tab="time-sheet" onclick="switchTab('time-sheet')">Табель учета</div>
                </div>
            </div>

            <div class="tab-content" id="about-companyContainer">
                <div class="about-company-tab-container">
                    <!-- Главный виджет о компании -->
                    <div class="main-block">
                        <span class="company-name">"Название компании"</span>
                        <!-- Контент о компании -->
                        <ul class="company-data-list">
                            <li class="company-data-item">
                                <company-data-item-key>ИНН</company-data-item-key>
                                <company-data-item-value>123456789012</company-data-item-value>
                            </li>
                            <li class="company-data-item">
                                <company-data-item-key>ОГРН</company-data-item-key>
                                <company-data-item-value>1234567890123</company-data-item-value>
                            </li>
                            <li class="company-data-item">
                                <company-data-item-key>Юр. адрес</company-data-item-key>
                                <company-data-item-value>г. Набережные Челны, ул. Пушкина, д. 18</company-data-item-value>
                            </li>
                            <li class="company-data-item">
                                <company-data-item-key>Факт. адрес</company-data-item-key>
                                <company-data-item-value>г. Набережные Челны, ул. Пушкина, д. 18</company-data-item-value>
                            </li>
                            <li class="company-data-item">
                                <company-data-item-key>Email</company-data-item-key>
                                <company-data-item-value>detailing@yandex.ru</company-data-item-value>
                            </li>
                            <li class="company-data-item">
                                <company-data-item-key>Телефон</company-data-item-key>
                                <company-data-item-value>+7 999 999 99 99</company-data-item-value>
                            </li>
                        </ul>
                    </div>
                    <!-- Второй виджет о налогообложении -->
                    <div class="secondaty-block">
                        <div class="secondary-block-title">Налоги и НДС</div>
                        <div class="nds-block">
                            <span class="nds-title">НДС</span>
                            <input type="text" class="nds-value">
                        </div>
                        <div class="usn-osno-switcher">
                            <span class="usn-title">УСН</span>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider round"></span>
                            </label>
                            <span>ОСНО</span>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>

<?php $render->component('dashboard_footer'); ?>