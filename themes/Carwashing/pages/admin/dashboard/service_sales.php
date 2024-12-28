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

// Товары
$product_service = $data['products'];
$products = $product_service->getAllFromDBAllSuppliers();

// Склады
$warehouse_service = $data['warehouses'];
$warehouses = $warehouse_service->getAllFromDB();

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

            <script>
                const productsJS = <?php echo json_encode($products, JSON_UNESCAPED_UNICODE); ?>;
            </script>

            <form id="cafeContainer"
                action="/admin/dashboard/service_sales/addNewProductSale"
                method="post"
                style="display: block;">

                <div id="productLinesContainer">
                    <!-- Одна строка (изначальная) -->
                    <div class="product-line" data-index="0">
                        <label>Товар + склад:</label>
                        <select name="products[0][product_warehouse]" class="productSelect" style="width: 320px;"></select>

                        <label>Кол-во:</label>
                        <input type="number" name="products[0][amount]" class="productAmountInput" value="1" min="1" style="width: 100px;">

                        <!-- Лейбл, где показываем "Всего на складе: XXX (ед. изм.)" -->
                        <label for="products[0][amount]" class="warehouseStockLabel">
                            Всего на складе: ---
                        </label>

                        <!-- Кнопка удаления позиции -->
                        <button type="button" class="removeLineBtn">X</button>
                    </div>
                </div>

                <!-- Кнопка добавления новой строки (ещё один товар) -->
                <button type="button" id="addLineBtn">Добавить товар</button>

                <div class="payment-section">
                    <div class="payment-options">
                        <label>Выбрать расчет</label>
                        <fieldset>
                            <label>
                                <input value="cash" name="payment_type" type="radio" checked> Наличный
                            </label>
                            <label>
                                <input value="card" name="payment_type" type="radio"> Безналичный
                            </label>
                        </fieldset>
                    </div>
                    <div class="total-amount">
                        <label>Итоговая сумма</label>
                        <div class="total-amount-value" id="productTotal">0 руб</div>
                    </div>
                </div>

                <button type="submit">Сохранить</button>
            </form>


        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productLinesContainer = document.getElementById('productLinesContainer');
        const addLineBtn = document.getElementById('addLineBtn');
        const totalAmountElem = document.getElementById('productTotal');

        // 1. Инициализация уже существующей строки (data-index="0")
        initializeLine(productLinesContainer.querySelector('.product-line'), 0);

        let lineIndex = 1; // следующая строка

        // 2. Кнопка "Добавить товар"
        addLineBtn.addEventListener('click', function() {
            // Создаём div
            const lineDiv = document.createElement('div');
            lineDiv.className = 'product-line';
            lineDiv.setAttribute('data-index', lineIndex);

            // HTML для новой строки
            lineDiv.innerHTML = `
            <label>Товар + склад:</label>
            <select name="products[${lineIndex}][product_warehouse]" class="productSelect" style="width: 320px;"></select>

            <label>Кол-во:</label>
            <input type="number" name="products[${lineIndex}][amount]" class="productAmountInput" value="1" min="1" style="width: 100px;">

            <label for="products[${lineIndex}][amount]" class="warehouseStockLabel">
                Всего на складе: ---
            </label>

            <button type="button" class="removeLineBtn">X</button>
        `;
            productLinesContainer.appendChild(lineDiv);

            initializeLine(lineDiv, lineIndex);
            lineIndex++;
        });

        /**
         * Функция инициализации логики в строке
         */
        function initializeLine(lineDiv, idx) {
            const productSelect = lineDiv.querySelector('.productSelect');
            const amountInput = lineDiv.querySelector('.productAmountInput');
            const removeBtn = lineDiv.querySelector('.removeLineBtn');

            // Лейбл, где показываем остаток
            const warehouseStockLabel = lineDiv.querySelector('.warehouseStockLabel');

            // Заполним <select> опциями
            fillProductSelect(productSelect);

            // Подключим Select2 (опционально)
            $(productSelect).select2({
                placeholder: 'Выбрать товар',
                allowClear: true,
                language: {
                    noResults: function() {
                        return 'Товар не найден';
                    }
                }
            }).on('change', function() {
                updateLineStockAndPrice(lineDiv);
                updateTotalPrice();
            });

            // При вводе количества
            amountInput.addEventListener('input', function() {
                updateTotalPrice();
            });

            // Удаление строки
            removeBtn.addEventListener('click', function() {
                lineDiv.remove();
                updateTotalPrice();
            });
        }

        /**
         * Заполняет <select> вариантами "товар+склад"
         * productsJS: массив, где каждый элемент = {id, name, warehouse_id, amount, unit_measurement, sale_price...}
         */
        function fillProductSelect(selectEl) {
            selectEl.innerHTML = '<option disabled selected>Выбрать товар</option>';
            productsJS.forEach(prod => {
                const opt = document.createElement('option');
                // value = "productId_warehouseId"
                opt.value = prod.id + '_' + prod.warehouse_id;
                opt.textContent = `${prod.name} [склад ${prod.warehouse_id}]`;
                // для пересчёта цены
                opt.setAttribute('data-price', prod.sale_price);
                // для вывода остатка
                opt.setAttribute('data-amount', prod.amount);
                // для вывода ед. изм.
                opt.setAttribute('data-unit', prod.unit_measurement);
                selectEl.appendChild(opt);
            });
        }

        /**
         * При выборе товара-склада обновляем лейбл "Всего на складе: ..."
         */
        function updateLineStockAndPrice(lineDiv) {
            const productSelect = lineDiv.querySelector('.productSelect');
            const warehouseStockLabel = lineDiv.querySelector('.warehouseStockLabel');

            const selectedOption = productSelect.options[productSelect.selectedIndex];
            if (!selectedOption) {
                warehouseStockLabel.textContent = 'Всего на складе: ---';
                return;
            }

            const wAmount = selectedOption.getAttribute('data-amount') || '0';
            const wUnit = selectedOption.getAttribute('data-unit') || '';
            warehouseStockLabel.textContent = `Всего на складе: ${wAmount} (${wUnit})`;
        }

        /**
         * Считает общую сумму по всем строкам
         */
        function updateTotalPrice() {
            let grandTotal = 0;

            document.querySelectorAll('.product-line').forEach(line => {
                const productSelect = line.querySelector('.productSelect');
                const amountInput = line.querySelector('.productAmountInput');

                const userAmount = parseFloat(amountInput.value) || 1;
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                if (!selectedOption) return;

                const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                const lineTotal = price * userAmount;
                grandTotal += lineTotal;
            });

            // Выводим результат
            document.getElementById('productTotal').textContent = `${grandTotal} руб`;
        }

        // Инициализация строки [0]
        updateLineStockAndPrice(productLinesContainer.querySelector('.product-line'));
        updateTotalPrice();
    });
</script>



<?php $render->component('dashboard_footer'); ?>