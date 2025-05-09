<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 * @var \Source\Models\Company $company
 * @var \Source\Models\CompanyType $company_type
 * @var \Source\Models\Supplier $supplier
 */

use Source\Models\Company;
use Source\Models\Supplier;

$user = $this->auth->getUser();
$companies = $data['companies'];
$company_types = $data['company_types'];
$suppliers = $data['suppliers'];


$employees_service  = $data['employees_service'];
$employees = $employees_service->getAllFromDB();

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
                <div class="financial-accounting-first__list-container">
                        <label class="financial-accounting-first__list-label">Добавленные позиции</label>
                        <div class="financial-accounting-first__list">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Имя</th>
                                        <th>Фамилия</th>
                                        <th>Отчество</th>
                                        <th>Должность</th>
                                        <th>Телефон</th>
                                        <th>Статус</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($employees as $employee => $employeeData): ?>
                                    <tr>
                                        <td><?php echo $employeeData->name();?></td>
                                        <td><?php echo $employeeData->last_name(); ?></td>
                                        <td><?php echo $employeeData->surname(); ?></td>
                                        <td><?php echo $employeeData->position(); ?></td>
                                        <td><?php echo $employeeData->phone(); ?></td>
                                        <td><?php echo $employeeData->status(); ?></td>
                                        <td>
                                            <button class="financial-accounting-first__edit-button">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7159 4.9375C10.7159 4.62684 10.4641 4.375 10.1534 4.375H2.6875C1.75552 4.375 1 5.13052 1 6.0625V17.3125C1 18.2445 1.75552 19 2.6875 19H13.9375C14.8695 19 15.625 18.2445 15.625 17.3125V9.84659C15.625 9.53593 15.3732 9.28409 15.0625 9.28409C14.7518 9.28409 14.5 9.53593 14.5 9.84659V17.3125C14.5 17.6232 14.2482 17.875 13.9375 17.875H2.6875C2.37684 17.875 2.125 17.6232 2.125 17.3125V6.0625C2.125 5.75184 2.37684 5.5 2.6875 5.5H10.1534C10.4641 5.5 10.7159 5.24816 10.7159 4.9375Z" fill="#707FDD" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19 1.5625C19 1.25184 18.7482 1 18.4375 1H12.8125C12.5018 1 12.25 1.25184 12.25 1.5625C12.25 1.87316 12.5018 2.125 12.8125 2.125H17.0795L7.91475 11.2898C7.69508 11.5094 7.69508 11.8656 7.91475 12.0852C8.13442 12.3049 8.49058 12.3049 8.71025 12.0852L17.875 2.9205V7.1875C17.875 7.49816 18.1268 7.75 18.4375 7.75C18.7482 7.75 19 7.49816 19 7.1875V1.5625Z" fill="#707FDD" />
                                                    <path d="M17.0795 2.125L17.3623 2.40784C17.4767 2.29344 17.511 2.1214 17.4491 1.97193C17.3871 1.82246 17.2413 1.725 17.0795 1.725V2.125ZM7.91475 11.2898L7.63191 11.0069L7.63191 11.0069L7.91475 11.2898ZM7.91475 12.0852L7.63191 12.3681L7.63191 12.3681L7.91475 12.0852ZM8.71025 12.0852L8.99309 12.3681H8.99309L8.71025 12.0852ZM17.875 2.9205H18.275C18.275 2.75871 18.1775 2.61286 18.0281 2.55094C17.8786 2.48903 17.7066 2.52325 17.5922 2.63765L17.875 2.9205ZM10.1534 4.775C10.2432 4.775 10.3159 4.84775 10.3159 4.9375H11.1159C11.1159 4.40593 10.685 3.975 10.1534 3.975V4.775ZM2.6875 4.775H10.1534V3.975H2.6875V4.775ZM1.4 6.0625C1.4 5.35143 1.97643 4.775 2.6875 4.775V3.975C1.5346 3.975 0.6 4.90961 0.6 6.0625H1.4ZM1.4 17.3125V6.0625H0.6V17.3125H1.4ZM2.6875 18.6C1.97643 18.6 1.4 18.0236 1.4 17.3125H0.6C0.6 18.4654 1.53461 19.4 2.6875 19.4V18.6ZM13.9375 18.6H2.6875V19.4H13.9375V18.6ZM15.225 17.3125C15.225 18.0236 14.6486 18.6 13.9375 18.6V19.4C15.0904 19.4 16.025 18.4654 16.025 17.3125H15.225ZM15.225 9.84659V17.3125H16.025V9.84659H15.225ZM15.0625 9.68409C15.1522 9.68409 15.225 9.75684 15.225 9.84659H16.025C16.025 9.31502 15.5941 8.88409 15.0625 8.88409V9.68409ZM14.9 9.84659C14.9 9.75684 14.9728 9.68409 15.0625 9.68409V8.88409C14.5309 8.88409 14.1 9.31502 14.1 9.84659H14.9ZM14.9 17.3125V9.84659H14.1V17.3125H14.9ZM13.9375 18.275C14.4691 18.275 14.9 17.8441 14.9 17.3125H14.1C14.1 17.4022 14.0272 17.475 13.9375 17.475V18.275ZM2.6875 18.275H13.9375V17.475H2.6875V18.275ZM1.725 17.3125C1.725 17.8441 2.15593 18.275 2.6875 18.275V17.475C2.59775 17.475 2.525 17.4022 2.525 17.3125H1.725ZM1.725 6.0625V17.3125H2.525V6.0625H1.725ZM2.6875 5.1C2.15592 5.1 1.725 5.53093 1.725 6.0625H2.525C2.525 5.97275 2.59775 5.9 2.6875 5.9V5.1ZM10.1534 5.1H2.6875V5.9H10.1534V5.1ZM10.3159 4.9375C10.3159 5.02725 10.2432 5.1 10.1534 5.1V5.9C10.685 5.9 11.1159 5.46907 11.1159 4.9375H10.3159ZM18.4375 1.4C18.5272 1.4 18.6 1.47275 18.6 1.5625H19.4C19.4 1.03093 18.9691 0.6 18.4375 0.6V1.4ZM12.8125 1.4H18.4375V0.6H12.8125V1.4ZM12.65 1.5625C12.65 1.47275 12.7228 1.4 12.8125 1.4V0.6C12.2809 0.6 11.85 1.03093 11.85 1.5625H12.65ZM12.8125 1.725C12.7228 1.725 12.65 1.65225 12.65 1.5625H11.85C11.85 2.09407 12.2809 2.525 12.8125 2.525V1.725ZM17.0795 1.725H12.8125V2.525H17.0795V1.725ZM8.1976 11.5726L17.3623 2.40784L16.7967 1.84216L7.63191 11.0069L8.1976 11.5726ZM8.1976 11.8024C8.13413 11.7389 8.13413 11.6361 8.1976 11.5726L7.63191 11.0069C7.25603 11.3828 7.25603 11.9922 7.63191 12.3681L8.1976 11.8024ZM8.42741 11.8024C8.36395 11.8659 8.26106 11.8659 8.19759 11.8024L7.63191 12.3681C8.00779 12.744 8.61721 12.744 8.99309 12.3681L8.42741 11.8024ZM17.5922 2.63765L8.42741 11.8024L8.99309 12.3681L18.1578 3.20334L17.5922 2.63765ZM18.275 7.1875V2.9205H17.475V7.1875H18.275ZM18.4375 7.35C18.3478 7.35 18.275 7.27725 18.275 7.1875H17.475C17.475 7.71907 17.9059 8.15 18.4375 8.15V7.35ZM18.6 7.1875C18.6 7.27725 18.5272 7.35 18.4375 7.35V8.15C18.9691 8.15 19.4 7.71907 19.4 7.1875H18.6ZM18.6 1.5625V7.1875H19.4V1.5625H18.6Z" fill="#707FDD" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="partnersContainer">
                <div class="partners-tab-container">
                    <h2>Добавить контрагента</h2>
                <form action="/admin/dashboard/company_managments/addSupplier" method="post">
                    <label for="name">Название</label>
                    <input type="text" name="name" required>

                    <label for="inn">ИНН</label>
                    <input type="text" name="inn" required>

                    <label for="ogrn">ОГРН</label>
                    <input type="text" name="ogrn" required>

                    <label for="legal_address">Юридический адрес</label>
                    <input type="text" name="legal_address" required>

                    <label for="actual_address">Фактический адрес</label>
                    <input type="text" name="actual_address" required>

                    <label for="phone">Телефон</label>
                    <input type="text" name="phone" required>

                    <label for="email">Email</label>
                    <input type="email" name="email" required>

                    <label for="contact_info">Контактная информация</label>
                    <input type="text" name="contact_info" required>

                    <button type="submit" class="company-button">Добавить контрагента</button>
                </form>

                    <h2>Список контрагентов</h2>
                    <div class="partners-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>ИНН</th>
                                    <th>ОГРН</th>
                                    <th>Юр. адрес</th>
                                    <th>Факт. адрес</th>
                                    <th>Телефон</th>
                                    <th>Email</th>
                                    <th>Контактная информация</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($suppliers as $supplier): ?>
                                <tr>
                                    <td><?php echo $supplier->name(); ?></td>
                                    <td><?php echo $supplier->inn(); ?></td>
                                    <td><?php echo $supplier->ogrn(); ?></td>
                                    <td><?php echo $supplier->legal_address(); ?></td>
                                    <td><?php echo $supplier->actual_address(); ?></td>
                                    <td><?php echo $supplier->phone(); ?></td>
                                    <td><?php echo $supplier->email(); ?></td>
                                    <td><?php echo $supplier->contact_info(); ?></td> <!-- Добавляем отображение -->
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<?php $render->component('dashboard_footer'); ?>