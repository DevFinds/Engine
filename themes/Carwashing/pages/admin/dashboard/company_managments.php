<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 */

$user = $this->auth->getUser();
$companies = $data['companies']->getCompanies();
$company_types = $data['company_types']->getAll();
dd($company_types);
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
        <div class="page-content-body">

            <div class="tabs-container">

                <div class="tabs">
                    <div class="tab active" data-tab="about-company" onclick="switchTab('about-company')">О компании</div>
                    <div class="tab" data-tab="employees-list" onclick="switchTab('employees-list')">Сотрудники</div>
                    <div class="tab" data-tab="partners" onclick="switchTab('partners')">Партнеры</div>
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

            <div class="tab-content" id="employees-listContainer">
                <div class="employees-list-tab-container">
                    <label class="financial-accounting-first-label">Список сотрудников</label>
                    <div class="employees-list">
                        <div class="employees-list-item">
                            <span class="employees-list-item-name">Иван Иванов</span>
                            <span class="employees-list-item-position">Директор</span>
                        </div>
                        <div class="employees-list-item">
                            <span class="employees-list-item-name">Иван Иванов</span>
                            <span class="employees-list-item-position">Директор</span>
                        </div>
                        <div class="employees-list-item">
                            <span class="employees-list-item-name">Иван Иванов</span>
                            <span class="employees-list-item-position">Директор</span>
                        </div>
                        <div class="employees-list-item">
                            <span class="employees-list-item-name">Иван Иванов</span>
                            <span class="employees-list-item-position">Директор</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="partnersContainer">
                <div class="partners-tab-container">
                    <label class="financial-accounting-first-label">Список партнеров</label>
                    <div class="partners-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Тип</th>
                                    <th>Название</th>
                                    <th>ИНН</th>
                                    <th>ОГРН</th>
                                    <th>Юр. адрес</th>
                                    <th>Факт. адрес</th>
                                    <th>Email</th>
                                    <th>Телефон</th>
                                    <th>Телефон</th>
                                    <th>Налоговый режим</th>
                                </tr>
                            </thead>
                            <tr>
                                <td>Партнер 1</td>
                                <td>ООО "Партнер 1"</td>
                                <td>123456789012</td>
                                <td>1234567890123</td>
                                <td>г. Набережные Челны, ул. Пушкина, д. 18</td>
                                <td>г. Набережные Челны, ул. Пушкина, д. 18</td>
                                <td>detailing@yandex.ru</td>
                                <td>+7 999 999 99 99</td>
                                <td>ОСНО</td>
                                <td>12%</td>
                            </tr>
                            <?php foreach ($companies as $company): ?>
                                <tr>
                                    <td><?php echo $company['type']; ?></td>
                                    <td>ООО "Партнер 1"</td>
                                    <td>123456789012</td>
                                    <td>1234567890123</td>
                                    <td>г. Набережные Челны, ул. Пушкина, д. 18</td>
                                    <td>г. Набережные Челны, ул. Пушкина, д. 18</td>
                                    <td>detailing@yandex.ru</td>
                                    <td>+7 999 999 99 99</td>
                                    <td>ОСНО</td>
                                    <td>12%</td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<?php $render->component('dashboard_footer'); ?>