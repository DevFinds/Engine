<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 * @var array $employees
 * @var array $productReports
 * @var array $products
 */
?>

<?php $render->component('dashboard_header'); ?>
<?php $render->component('menu_sidebar'); ?>

<div class="page-content-container">
    <div class="page-content">
        <?php $render->component('pagecontent_header'); ?>

        <div class="page-content-body">
            <div class="tabs-container">
                <div class="tabs">
                    <div class="tab active" data-tab="create-report" onclick="switchTab('create-report')">Создать отчет</div>
                    <div class="tab" data-tab="reports" onclick="switchTab('reports')">Отчеты</div>
                    <div class="tab" data-tab="last-actions" onclick="switchTab('last-actions')">Последние действия</div>
                </div>
            </div>

            <div class="tab-content" id="create-reportContainer">
                <div class="create-report-tab-container">
                    <label class="financial-accounting-first-label">Создание отчета</label>
                    <div id="formMessage" style="color: red; display: none;"></div>

                    <div class="create-report-container" id="createReport">
                        <div class="financial-accounting-first__create">
                            <form class="financial-accounting-first__create-forms" id="reportForm" method="POST" action="/admin/dashboard/reports/getReport">
                                <ul class="financial-accounting-first__create-first-column">
                                    <li>
                                        <select class="financial-accounting-first__create-select" name="report_type">
                                            <option value="employee">Отчет по сотрудникам</option>
                                            <option value="product" selected>Отчет по продуктам</option>
                                        </select>
                                    </li>
                                    <li>
                                        <input type="date" name="start_date" placeholder="Дата начала">
                                    </li>
                                </ul>
                                <ul class="financial-accounting-first__create-second-column">
                                    <li>
                                        <select class="financial-accounting-first__create-select" name="product_id">
                                            <option value="">Все</option>
                                            <?php foreach ($products as $product): ?>
                                                <option value="<?= htmlspecialchars($product['id']) ?>"><?= htmlspecialchars($product['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </li>
                                    <li>
                                        <input type="date" name="end_date" placeholder="Дата конца">
                                    </li>
                                </ul>
                                <div class="financial-accounting-first__buttons">
                                    <button type="submit" class="financial-accounting-first__button-save">Сформировать</button>
                                    <button type="button" class="financial-accounting-first__button-clear" onclick="clearForm()">Очистить</button>
                                </div>
                            </form>
                            <?php if (!empty($productReports)): ?>
                                <form action="/admin/dashboard/reports/export" method="POST" id="exportForm" style="margin-top:1em;">
                                    <!-- Заполняем скрытые поля теми же фильтрами -->
                                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($selectedProductId) ?>">
                                    <input type="hidden" name="start_date" value="<?= htmlspecialchars($selectedStartDate) ?>">
                                    <input type="hidden" name="end_date" value="<?= htmlspecialchars($selectedEndDate) ?>">
                                    <button type="submit" class="financial-accounting-first__button-export">
                                        Экспортировать в Excel
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="financial-accounting-first__list-container">
                        <label class="financial-accounting-first__list-label">Создан отчет</label>
                        <div class="financial-accounting-first__list">
                            <table id="productReportTable">
                                <thead>
                                    <tr>
                                        <th>Наименование</th>
                                        <th>Кол-во</th>
                                        <th>Цена</th>
                                        <th>Сумма</th>
                                        <th>Сотрудник</th>
                                        <th>Дата</th>
                                    </tr>
                                </thead>
                                <tbody id="productReportBody">

                                    <?php

                                    if (empty($productReports)) {
                                    ?>
                                        <tr>
                                            <td colspan="6">Выберите параметры и нажмите "Сформировать" для отображения отчета</td>
                                        </tr>
                                        <?php
                                    } else {
                                        foreach ($productReports as $productReport) {
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($productReport['product_name']) ?></td>
                                                <td><?= htmlspecialchars($productReport['quantity']) ?></td>
                                                <td><?= htmlspecialchars($productReport['price']) ?></td>
                                                <td><?= htmlspecialchars($productReport['total']) ?></td>
                                                <td><?= htmlspecialchars($productReport['employee_name']) ?></td>
                                                <td><?= htmlspecialchars($productReport['sale_date']) ?></td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>




            </div>

            <div class="tab-content" id="reportsContainer" style="display: none;">
                <div class="reports-tab-container">
                    <label class="financial-accounting-first-label">Фильтрация отчетов</label>
                    <div class="reports-container" id="createReport">
                        <div class="financial-accounting-first__create">
                            <form class="financial-accounting-first__create-forms">
                                <ul class="financial-accounting-first__create-first-column">
                                    <li>
                                        <select class="financial-accounting-first__create-select">
                                            <option disabled selected>Все отчеты</option>
                                        </select>
                                    </li>
                                    <li>
                                        <input type="date" placeholder="Дата начала">
                                    </li>
                                </ul>
                                <ul class="financial-accounting-first__create-second-column">
                                    <li>
                                        <select class="financial-accounting-first__create-select">
                                            <option disabled selected>Все</option>
                                        </select>
                                    </li>
                                    <li><input type="date" placeholder="Дата конца"></li>
                                </ul>
                            </form>
                            <div class="financial-accounting-first__buttons">
                                <button class="financial-accounting-first__button-save">Сохранить</button>
                                <button class="financial-accounting-first__button-clear">Очистить</button>
                            </div>
                        </div>
                    </div>
                    <div class="financial-accounting-first__list-container">
                        <label class="financial-accounting-first__list-label">Создан отчет</label>
                        <div class="report-search-results">
                            <div class="report">
                                <div class="report-header">
                                    <div class="report-title">Отчет №12</div>
                                    <span class="report-date">Создан: 13.09.2024</span>
                                </div>
                                <div class="report-body">
                                    <div class="report-type"><span class="report-type-label">Тип:</span> Отчет по сотрудникам</div>
                                    <div class="report-selection"><span class="report-selection-label">Выборка:</span> Все сотрудники</div>
                                    <div class="report-dates">
                                        <span class="report-period">13.07.2024 / 28.09.2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="last-actionsContainer" style="display: none;">
                <div class="financial-accounting-first__list">
                            <table id="productReportTable">
                                <thead>
                                    <tr>
                                        <th>Сотрудник</th>
                                        <th>Кол-во</th>
                                        <th>Цена</th>
                                        <th>Сумма</th>
                                        <th>Сотрудник</th>
                                        <th>Дата</th>
                                    </tr>
                                </thead>
                                <tbody id="productReportBody">

                                    <?php

                                    if (empty($productReports)) {
                                    ?>
                                        <tr>
                                            <td colspan="6">Выберите параметры и нажмите "Сформировать" для отображения отчета</td>
                                        </tr>
                                        <?php
                                    } else {
                                        foreach ($productReports as $productReport) {
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($productReport['product_name']) ?></td>
                                                <td><?= htmlspecialchars($productReport['quantity']) ?></td>
                                                <td><?= htmlspecialchars($productReport['price']) ?></td>
                                                <td><?= htmlspecialchars($productReport['total']) ?></td>
                                                <td><?= htmlspecialchars($productReport['employee_name']) ?></td>
                                                <td><?= htmlspecialchars($productReport['sale_date']) ?></td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
            </div>

            
        </div>
    </div>
</div>




<?php $render->component('dashboard_footer'); ?>