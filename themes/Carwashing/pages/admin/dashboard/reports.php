<?php
/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 * @var array $employees
 * @var array $productReports
 * @var array $products
 * @var array $services
 * @var array $reports
 * @var string $reportType
 * @var string $selectedId
 * @var string $selectedStartDate
 * @var string $selectedEndDate
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
                                        <select class="financial-accounting-first__create-select" name="report_type" id="report_type">
                                            <option value="product" <?= ($reportType ?? 'product') === 'product' ? 'selected' : '' ?>>Отчет по продуктам</option>
                                            <option value="service" <?= ($reportType ?? 'product') === 'service' ? 'selected' : '' ?>>Отчет по услугам</option>
                                        </select>
                                    </li>
                                    <li>
                                        <input type="date" name="start_date" value="<?= htmlspecialchars($selectedStartDate ?? '') ?>" placeholder="Дата начала">
                                    </li>
                                </ul>
                                <ul class="financial-accounting-first__create-second-column">
                                    <li id="product_select_container" style="display: <?= ($reportType ?? 'product') === 'product' ? 'block' : 'none' ?>;">
                                        <select class="financial-accounting-first__create-select" name="product_id">
                                            <option value="">Все продукты</option>
                                            <?php foreach ($products as $product): ?>
                                                <option value="<?= htmlspecialchars($product['id']) ?>" <?= ($selectedId ?? '') === $product['id'] && ($reportType ?? 'product') === 'product' ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($product['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </li>
                                    <li id="service_select_container" style="display: <?= ($reportType ?? 'product') === 'service' ? 'block' : 'none' ?>;">
                                        <select class="financial-accounting-first__create-select" name="service_id">
                                            <option value="">Все услуги</option>
                                            <?php if (empty($services)): ?>
                                                <option value="" disabled>Нет доступных услуг</option>
                                            <?php else: ?>
                                                <?php foreach ($services as $service): ?>
                                                    <option value="<?= htmlspecialchars($service['id']) ?>" <?= ($selectedId ?? '') === $service['id'] && ($reportType ?? 'product') === 'service' ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($service['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </li>
                                    <li>
                                        <input type="date" name="end_date" value="<?= htmlspecialchars($selectedEndDate ?? '') ?>" placeholder="Дата конца">
                                    </li>
                                </ul>
                                <div class="financial-accounting-first__buttons">
                                    <button type="submit" class="financial-accounting-first__button-save">Сформировать</button>
                                    <button type="button" class="financial-accounting-first__button-clear" onclick="clearForm()">Очистить</button>
                                </div>
                            </form>
                            <?php if (!empty($reports)): ?>
                                <form action="/admin/dashboard/reports/export" method="POST" id="exportForm" style="margin-top:1em;">
                                    <input type="hidden" name="report_type" value="<?= htmlspecialchars($reportType ?? 'product') ?>">
                                    <input type="hidden" name="<?= ($reportType ?? 'product') === 'service' ? 'service_id' : 'product_id' ?>" value="<?= htmlspecialchars($selectedId ?? '') ?>">
                                    <input type="hidden" name="start_date" value="<?= htmlspecialchars($selectedStartDate ?? '') ?>">
                                    <input type="hidden" name="end_date" value="<?= htmlspecialchars($selectedEndDate ?? '') ?>">
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
                            <table id="reportTable">
                                <thead>
                                    <tr>
                                        <?php if (($reportType ?? 'product') === 'service'): ?>
                                            <th>Марка машины</th>
                                            <th>Номер</th>
                                            <th>Наименование</th>
                                            <th>Дата время</th>
                                            <th>Тип оплаты</th>
                                            <th>Сумма</th>
                                        <?php else: ?>
                                            <th>Наименование</th>
                                            <th>Кол-во</th>
                                            <th>Цена</th>
                                            <th>Сумма</th>
                                            <th>Сотрудник</th>
                                            <th>Дата</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody id="reportBody">
                                    <?php if (empty($reports)): ?>
                                        <tr>
                                            <td colspan="<?= ($reportType ?? 'product') === 'service' ? 6 : 6 ?>">Выберите параметры и нажмите "Сформировать" для отображения отчета</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($reports as $report): ?>
                                            <tr>
                                                <?php if (($reportType ?? 'product') === 'service'): ?>
                                                    <td><?= htmlspecialchars($report['car_brand'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($report['car_number'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($report['name'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($report['sale_date'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($report['payment_method'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($report['total'] ?? '') ?></td>
                                                <?php else: ?>
                                                    <td><?= htmlspecialchars($report['product_name'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($report['quantity'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($report['price'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($report['total'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($report['employee_name'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($report['sale_date'] ?? '') ?></td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
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
                                <th>Наименование</th>
                                <th>Кол-во</th>
                                <th>Цена</th>
                                <th>Сумма</th>
                                <th>Сотрудник</th>
                                <th>Дата</th>
                            </tr>
                        </thead>
                        <tbody id="productReportBody">
                            <?php if (empty($productReports)): ?>
                                <tr>
                                    <td colspan="6">Выберите параметры и нажмите "Сформировать" для отображения отчета</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($productReports as $productReport): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($productReport['product_name'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($productReport['quantity'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($productReport['price'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($productReport['total'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($productReport['employee_name'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($productReport['sale_date'] ?? '') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $render->component('dashboard_footer'); ?>