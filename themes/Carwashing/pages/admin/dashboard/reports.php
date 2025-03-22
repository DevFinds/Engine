<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 * @var \Source\Models\Employee $employee
 */
$employees = $data['employees'];
$employeeReports = $data['employeeReports'];
$employeeRawData = $data['employeeRawData'];
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
                    <div class="tab active" data-tab="create-report" onclick="switchTab('create-report')">Создать отчет</div>
                    <div class="tab" data-tab="reports" onclick="switchTab('reports')">Отчеты</div>
                </div>
            </div>

            <div class="tab-content" id="create-reportContainer">
                <div class="create-report-tab-container">
                    <label class="financial-accounting-first-label">Создание отчета</label>

                    <div class="create-report-container" id="createReport">
                        <div class="financial-accounting-first__create">
                            <form class="financial-accounting-first__create-forms" method="POST" action="/admin/dashboard/reports">
                                <ul class="financial-accounting-first__create-first-column">
                                    <li>
                                        <select class="financial-accounting-first__create-select">
                                            <option disabled selected value="employee">Отчет по сотрудникам</option>
                                            <option value="product">Отчет по продуткам</option>
                                        </select>
                                    </li>
                                    <li>
                                        <input type="date" placeholder="Дата начала">
                                    </li>
                                </ul>
                                <ul class="financial-accounting-first__create-second-column">
                                    <li>
                                        <select class="financial-accounting-first__create-select">
                                            <option disabled selected>Сотрудник</option>
                                            <?php foreach ($employees as $employee => $employee_model) : ?>
                                                <option value="<?= $employee_model->id() ?>"><?= $employee_model->name() ?></option>
                                            <?php endforeach; ?>
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
                        <label class="financial-accounting-first__list-label">Создан отчет</label></label>
                        <div class="financial-accounting-first__list">
                        <table id="employeeReportTable">
                                <thead>
                                    <tr>
                                        <th>Сотрудник</th>
                                        <th>Отработанные часы</th>
                                        <th>Количество услуг</th>
                                        <th>Сумма зарплаты</th>
                                        <th>Средняя стоимость услуги</th>
                                        <th>Средние часы в день</th>
                                    </tr>
                                </thead>
                                <tbody id="employeeReportBody">
                                    <?php if (empty($employeeReports)): ?>
                                        <tr>
                                            <td colspan="6">Нет данных для отображения</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($employeeReports as $report): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($report['employee_name'] ?? 'Не указано') ?></td>
                                                <td><?= htmlspecialchars($report['total_hours'] ?? 0) ?></td>
                                                <td><?= htmlspecialchars($report['total_services'] ?? 0) ?></td>
                                                <td><?= htmlspecialchars(number_format($report['total_salary'] ?? 0, 2)) ?> ₽</td>
                                                <td><?= htmlspecialchars(number_format($report['avg_service_price'] ?? 0, 2)) ?> ₽</td>
                                                <td><?= htmlspecialchars(number_format($report['avg_hours_per_day'] ?? 0, 2)) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="reportsContainer">
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
                        <label class="financial-accounting-first__list-label">Создан отчет</label></label>
                        <div class="report-search-results">
                            <div class="report">
                                <div class="report-header">
                                    <div class="report-title">Отчет №12</div>
                                    <span class="report-date">Создан: 13.09.2024</span>
                                </div>
                                <div class="report-body">
                                    <div class="report-type"><span class="report-type-label">Тип:</span> Отчет по сотрудникам</div>
                                    <div class="report-selection"> <span class="report-selection-label">Выборка:</span> Все сотрудники</div>
                                    <div class="report-dates">
                                        <span class="report-period">13.07.2024 / 28.09.2024</span>
                                    </div>
                                </div>
                            </div>
                            <div class="report">
                                <div class="report-header">
                                    <div class="report-title">Отчет №12</div>
                                    <span class="report-date">Создан: 13.09.2024</span>
                                </div>
                                <div class="report-body">
                                    <div class="report-type"><span class="report-type-label">Тип:</span> Отчет по сотрудникам</div>
                                    <div class="report-selection"> <span class="report-selection-label">Выборка:</span> Все сотрудники</div>
                                    <div class="report-dates">
                                        <span class="report-period">13.07.2024 / 28.09.2024</span>
                                    </div>
                                </div>
                            </div>
                            <div class="report">
                                <div class="report-header">
                                    <div class="report-title">Отчет №12</div>
                                    <span class="report-date">Создан: 13.09.2024</span>
                                </div>
                                <div class="report-body">
                                    <div class="report-type"><span class="report-type-label">Тип:</span> Отчет по сотрудникам</div>
                                    <div class="report-selection"> <span class="report-selection-label">Выборка:</span> Все сотрудники</div>
                                    <div class="report-dates">
                                        <span class="report-period">13.07.2024 / 28.09.2024</span>
                                    </div>
                                </div>
                            </div>
                            <div class="report">
                                <div class="report-header">
                                    <div class="report-title">Отчет №12</div>
                                    <span class="report-date">Создан: 13.09.2024</span>
                                </div>
                                <div class="report-body">
                                    <div class="report-type"><span class="report-type-label">Тип:</span> Отчет по сотрудникам</div>
                                    <div class="report-selection"> <span class="report-selection-label">Выборка:</span> Все сотрудники</div>
                                    <div class="report-dates">
                                        <span class="report-period">13.07.2024 / 28.09.2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $render->component('dashboard_footer'); ?>
<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.style.display = 'none';
        });
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });
        document.getElementById(tabId + 'Container').style.display = 'block';
        document.querySelector(`.tab[data-tab="${tabId}"]`).classList.add('active');
    }

    function clearForm() {
        document.getElementById('reportForm').reset();
        document.getElementById('employeeReportBody').innerHTML = '<tr><td colspan="6">Выберите параметры и нажмите "Сохранить" для формирования отчета</td></tr>';
    }

    function updateReport() {
        const form = document.getElementById('reportForm');
        const formData = new FormData(form);
        fetch('/admin/dashboard/reports/get', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('employeeReportBody');
            tbody.innerHTML = '';

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6">Нет данных для отображения</td></tr>';
                return;
            }

            data.forEach(report => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${report.employee_name ?? 'Не указано'}</td>
                    <td>${report.total_hours ?? 0}</td>
                    <td>${report.total_services ?? 0}</td>
                    <td>${(report.total_salary ?? 0).toFixed(2)} ₽</td>
                    <td>${(report.avg_service_price ?? 0).toFixed(2)} ₽</td>
                    <td>${(report.avg_hours_per_day ?? 0).toFixed(2)}</td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('employeeReportBody').innerHTML = '<tr><td colspan="6">Ошибка при загрузке данных</td></tr>';
        });
    }

    document.getElementById('reportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updateReport();
    });
</script>