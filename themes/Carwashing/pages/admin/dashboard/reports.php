<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 * @var array $employees
 * @var array $productReports
 * @var array $products
 * @var array $services
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
                    <div class="tab" id="lastActionsTab" data-tab="last-actions" onclick="switchTab('last-actions')">Последние действия</div>
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
                                            <option value="employee">Отчет по сотрудникам</option>
                                            <option value="product" selected>Отчет по продуктам</option>
                                            <option value="service">Отчет по услугам</option>
                                        </select>
                                    </li>
                                    <li>
                                        <input type="date" name="start_date" placeholder="Дата начала">
                                    </li>
                                </ul>
                                <ul class="financial-accounting-first__create-second-column">
                                    <li id="product_select_container" style="display: block;">
                                        <select class="financial-accounting-first__create-select" name="product_id" id="product_id">
                                            <option value="">Все продукты</option>
                                            <?php foreach ($products as $product): ?>
                                                <option value="<?= htmlspecialchars($product['id']) ?>"><?= htmlspecialchars($product['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </li>
                                    <li id="service_select_container" style="display: none;">
                                        <select class="financial-accounting-first__create-select" name="service_id" id="service_id">
                                            <option value="">Все услуги</option>
                                            <?php foreach ($services as $service): ?>
                                                <option value="<?= htmlspecialchars($service['id']) ?>"><?= htmlspecialchars($service['name']) ?></option>
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
                                    <input type="hidden" name="report_type" value="<?= htmlspecialchars($reportType ?? 'product') ?>">
                                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($selectedProductId ?? '') ?>">
                                    <input type="hidden" name="service_id" value="<?= htmlspecialchars($selectedServiceId ?? '') ?>">
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
                                        <?php foreach ($productReports as $report): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($report['name']) ?></td>
                                                <td><?= htmlspecialchars($report['quantity']) ?></td>
                                                <td><?= htmlspecialchars($report['price']) ?></td>
                                                <td><?= htmlspecialchars($report['total']) ?></td>
                                                <td><?= htmlspecialchars($report['employee_name']) ?></td>
                                                <td><?= htmlspecialchars($report['sale_date']) ?></td>
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
                    <table id="lastActionsTable">
                        <thead>
                            <tr>
                                <th>ID Сотрудника</th>
                                <th>Тип действия</th>
                                <th>Информация</th>
                                <th>Дата</th>
                            </tr>
                        </thead>
                        <tbody id="lastActionsBody">
                            <!-- JS вставит сюда <tr>...<tr/> -->
                        </tbody>
                    </table>
                    <div id="lastActionsLoader" style="display: none;">Загрузка последних действий…</div>
                    <div id="lastActionsError" style="color: red; display: none;"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Обработка табов
    function switchTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
        document.getElementById(tabName + 'Container').style.display = 'block';
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        document.querySelector(`.tab[data-tab="${tabName}"]`).classList.add('active');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const tab = document.getElementById('lastActionsTab');
        const tbody = document.getElementById('lastActionsBody');
        const loader = document.getElementById('lastActionsLoader');
        const errorBox = document.getElementById('lastActionsError');

        tab.addEventListener('click', async () => {
            switchTab('last-actions');

            if (tbody.children.length > 0) return;

            loader.style.display = 'block';
            errorBox.style.display = 'none';

            try {
                const response = await fetch('/admin/dashboard/reports/get-last-actions');
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                const actions = await response.json();
                loader.style.display = 'none';

                if (!actions.length) {
                    tbody.innerHTML = '<tr><td colspan="4">Нет записей</td></tr>';
                    return;
                }

                const rows = actions.map(act => {
                    const employee = act.actor_name || act.actor
                    const type = act.action_name;

                    let infoList = '';
                    try {
                        const infoObj = typeof act.action_info === 'string' ?
                            JSON.parse(act.action_info) :
                            act.action_info;
                        infoList = Object.entries(infoObj)
                            .map(([key, val]) => `<li><strong>${key}:</strong> ${val}</li>`)
                            .join('');
                    } catch {
                        infoList = `<li>${act.action_info}</li>`;
                    }

                    const infoCell = `
          <details>
            <summary>Показать детали</summary>
            <ul>${infoList}</ul>
          </details>`;

                    const date = new Date(act.action_date).toLocaleString();

                    return `
          <tr>
            <td>${employee}</td>
            <td>${type}</td>
            <td>${infoCell}</td>
            <td>${date}</td>
          </tr>`;
                }).join('');

                tbody.innerHTML = rows;
            } catch (err) {
                loader.style.display = 'none';
                errorBox.textContent = 'Ошибка загрузки: ' + err.message;
                errorBox.style.display = 'block';
            }
        });
    });
</script>

<?php $render->component('dashboard_footer'); ?>