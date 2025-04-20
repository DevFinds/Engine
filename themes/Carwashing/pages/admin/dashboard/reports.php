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
                </div>
            </div>

            <div class="tab-content" id="create-reportContainer">
                <div class="create-report-tab-container">
                    <label class="financial-accounting-first-label">Создание отчета</label>
                    <div id="formMessage" style="color: red; display: none;"></div>

                    <div class="create-report-container" id="createReport">
                        <div class="financial-accounting-first__create">
                            <form class="financial-accounting-first__create-forms" id="reportForm">
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
                                            <?php if (!empty($products)) : ?>
                                                <?php foreach ($products as $product) : ?>
                                                    <option value="<?= $product->id() ?>"><?= $product->name() ?></option>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <option disabled>Нет доступных товаров</option>
                                            <?php endif; ?>
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
                                    <tr>
                                        <td colspan="6">Выберите параметры и нажмите "Сформировать" для отображения отчета</td>
                                    </tr>
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
        const form = document.getElementById('reportForm');
        const messageDiv = document.getElementById('formMessage');
        const tbody = document.getElementById('productReportBody');

        if (form) form.reset();
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="6">Выберите параметры и нажмите "Сформировать" для отображения отчета</td></tr>';
        }
        if (messageDiv) {
            messageDiv.style.display = 'none';
            messageDiv.innerHTML = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('reportForm');
        if (!form) {
            console.error('Форма с ID reportForm не найдена');
            return;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            const messageDiv = document.getElementById('formMessage');
            const tbody = document.getElementById('productReportBody');

            if (!messageDiv || !tbody) {
                console.error('Элементы formMessage или productReportBody не найдены');
                return;
            }

            messageDiv.style.display = 'none';
            messageDiv.innerHTML = '';

            fetch('/admin/dashboard/reports/getReport', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Полученные данные:', data); // Для отладки
                tbody.innerHTML = '';

                if (data.error) {
                    messageDiv.style.display = 'block';
                    messageDiv.innerHTML = data.error;
                    tbody.innerHTML = '<tr><td colspan="6">Нет данных для отображения</td></tr>';
                    return;
                }

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6">Нет данных для отображения</td></tr>';
                    return;
                }

                data.forEach(report => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${report.product_name || 'N/A'}</td>
                        <td>${report.quantity || 0}</td>
                        <td>${report.price || '0.00'} ₽</td>
                        <td>${report.total || '0.00'} ₽</td>
                        <td>${report.employee_name || 'N/A'}</td>
                        <td>${report.sale_date || 'N/A'}</td>
                    `;
                    tbody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Ошибка:', error);
                messageDiv.style.display = 'block';
                messageDiv.innerHTML = `Ошибка при загрузке данных: ${error.message}`;
                tbody.innerHTML = '<tr><td colspan="6">Ошибка при загрузке данных</td></tr>';
            });
        });
    });
</script>