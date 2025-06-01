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
$users = $data['users']->getAllFromDB();

// Товары
$product_service = $data['products'];
$products = $product_service->getAllFromDBAllSuppliers();

// Склады
$warehouse_service = $data['warehouses'];
$warehouses = $warehouse_service->getAllFromDB();

// Классы автомобилей
$car_classes_service = $data['car_classes_service'];
$car_classes = $car_classes_service->getAllFromDB();

$services_array = $data['service']->getAllFromDBAsArray();


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
            <script>
                const servicesJS = <?php echo json_encode($services_array, JSON_UNESCAPED_UNICODE); ?>;
                const carClassesJS = <?php echo isset($car_classes) ? json_encode($car_classes, JSON_UNESCAPED_UNICODE) : '[]'; ?>;
                const carsJS = <?php echo json_encode($data['cars'], JSON_UNESCAPED_UNICODE); ?>;
            </script>

            <form id="carWashContainer" action="/admin/dashboard/service_sales/addNewServiceSale" method="post" class="tab-content" style="display: block;">
                <!-- Блок с множеством услуг -->
                <div id="servicesLinesContainer">
                    <!-- Одна строка (пример) -->
                    <div class="service-line" data-index="0">
                        <div class="service-line-service">
                            <label>Услуга</label>
                            <select name="services[0][service_id]" class="serviceSelect" style="width: auto;"></select>
                        </div>
                        <div class="service-line-btn">
                            <label for="">ㅤ</label>
                            <button type="button" class="removeServiceBtn"><img src="/assets/themes/Carwashing/img/trash-icon.svg" alt=""></button>
                        </div>
                    </div>
                </div>

                <!-- Кнопка добавления новой строки (ещё одна услуга) -->
                <button type="button" id="addServiceBtn">Добавить услугу</button>
                <!-- Общие поля: сотрудник, номер машины, модель, марка, payment_type -->
                <div class="about-service-forms">
                    <ul class="about-service-forms-first-column">
                        <li>
                            <label class="about-service-form-label">Исполнитель</label>
                            <select class="about-service-form" name="employee_id" required>
                                <option disabled selected>Выбрать исполнителя</option>
                                <?php foreach ($users as $user_model) : ?>
                                    <option value="<?= $user_model->id() ?>"><?= $user_model->username() ?> <?= $user_model->lastname() ?></option>
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
                        <li>
                            <label class="about-service-form-label">Гос.номер автомобиля</label>
                            <select name="state_number" id="stateNumberInput" class="about-service-form" required></select>
                        </li>
                        </li>
                        <li>
                            <label class="about-service-form-label">Марка автомобиля</label>
                            <input type="text" name="car_brand" id="carBrandInput" placeholder="Ввести марку" required>
                        </li>
                        <li>
                            <label class="about-service-form-label">Класс автомобиля</label>
                            <select class="about-service-form" name="class_id" id="classSelect" required>
                                <option disabled selected>Выбрать класс</option>
                                <?php foreach ($car_classes as $class) : ?>
                                    <option value="<?= $class->id() ?>" data-percent="<?= $class->markup() ?>">
                                        <?= $class->name() ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </li>
                    </ul>
                </div>

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
                        <label class="total-amount-label">Итоговая сумма</label>
                        <div name="total_amount_service" class="total-amount-value" id="serviceTotal">0 руб</div>
                    </div>
                </div>
                <button type="submit" class="save-button">Сохранить</button>
            </form>

            <script>
                const productsJS = <?php echo json_encode($products, JSON_UNESCAPED_UNICODE); ?>;
            </script>

            <form id="cafeContainer"
                action="/admin/dashboard/service_sales/addNewProductSale"
                method="post"
                style="display: block;"
                class="tab-content">

                <div id="productLinesContainer">
                    <!-- Одна строка (изначальная) -->
                    <div class="product-line" data-index="0">
                        <div class="product-line-good">
                            <label>Товар</label>
                            <select name="products[0][product_warehouse]" class="productSelect" style="width: 320px;"></select>
                        </div>

                        <div class="product-line-count">
                            <label>Кол-во</label>
                            <input type="number" name="products[0][amount]" class="productAmountInput" value="1" min="1" style="width: 100px;">
                        </div>

                        <div class="product-line-btn">
                            <!-- Лейбл, где показываем "Всего на складе: XXX (ед. изм.)" -->
                            <label for="products[0][amount]" class="warehouseStockLabel">
                                Всего на складе:
                            </label>

                            <!-- Кнопка удаления позиции -->
                            <button type="button" class="removeLineBtn"><img src="/assets/themes/Carwashing/img/trash-icon.svg" alt=""></button>
                        </div>
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
                        <div name="total_amount" class="total-amount-value" id="productTotal">0 руб</div>
                    </div>
                </div>

                <button type="submit" id="saveLineBtn">Сохранить</button>
            </form>


        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        /* ================================
           Общие переменные и функции
           ================================ */
        const productLinesContainer = document.getElementById('productLinesContainer');
        const addProductBtn = document.getElementById('addLineBtn');
        const productSaveBtn = document.getElementById('saveLineBtn');
        const productTotalElem = document.getElementById('productTotal');

        const serviceLinesContainer = document.getElementById('servicesLinesContainer');
        const addServiceBtn = document.getElementById('addServiceBtn');
        const serviceTotalElem = document.getElementById('serviceTotal');
        const stateNumberInput = document.getElementById('stateNumberInput');
        const carBrandInput = document.getElementById('carBrandInput');
        const classSelect = document.getElementById('classSelect');
        let productLineIndex = 0;
        let serviceLineIndex = 0;


        /* ================================
           Логика автозаполнения гос. номеров
           ================================ */
        const select2Data = Array.isArray(carsJS) ? carsJS.map(car => ({
            id: car.state_number,
            text: car.state_number,
            car_brand: car.car_brand,
            class_id: car.class_id
        })) : [];

        $(stateNumberInput).select2({
            ajax: {
                url: '/admin/cars/autocomplete',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(car => ({
                            id: car.state_number,
                            text: car.state_number,
                            car_brand: car.car_brand,
                            class_id: car.class_id
                        }))
                    };
                }
            },
            placeholder: 'A000AA00',
            minimumInputLength: 2,
            allowClear: true,
            tags: true,
            width: '100%',
            language: {
                inputTooShort: function() {
                    return 'Пожалуйста, введите 2 символа';
                },
                noResults: function() {
                    return 'Номер не найден';
                }
            }
        }).on('select2:select', function(e) {
            const data = e.params.data;
            stateNumberInput.value = data.id;
            carBrandInput.value = data.car_brand || '';
            classSelect.value = data.class_id || '';
            updateServiceTotal();
        }).on('select2:unselect', function() {
            carBrandInput.value = '';
            classSelect.value = '';
            updateServiceTotal();
        }).on('change', function() {
            const val = $(this).val();
            if (!val) {
                carBrandInput.value = '';
                classSelect.value = '';
            }
            stateNumberInput.value = val; // синхронизируем input
            updateServiceTotal();
        });

        /* ================================
           Логика для товаров (Кафе)
           ================================ */
        function fillProductSelect(selectEl) {
            selectEl.innerHTML = '<option disabled selected>Выбрать товар</option>';
            productsJS.forEach(prod => {
                const opt = document.createElement('option');
                opt.value = `${prod.id}_${prod.warehouse_id}`;
                opt.textContent = `${prod.name} [склад ${prod.warehouse_id}]`;
                opt.dataset.price = prod.sale_price;
                opt.dataset.amount = prod.amount;
                opt.dataset.unit = prod.unit_measurement;
                selectEl.appendChild(opt);
            });
        }

        function initializeProductLine(lineDiv, idx) {
            const selectEl = lineDiv.querySelector('.productSelect');
            const inputEl = lineDiv.querySelector('.productAmountInput');
            const stockLabel = lineDiv.querySelector('.warehouseStockLabel');
            const errorMsg = document.createElement('div');
            errorMsg.className = 'input-error';
            errorMsg.style.color = 'red';
            inputEl.parentNode.appendChild(errorMsg);

            fillProductSelect(selectEl);
            $(selectEl).select2({
                placeholder: 'Выбрать товар',
                allowClear: true,
                width: '320px',
                language: {
                    noResults: () => 'Товар не найден'
                }
            }).on('change', () => {
                validateProductLine();
                updateProductTotal();
            });

            inputEl.addEventListener('input', () => {
                inputEl.value = inputEl.value.replace(/[^\d]/g, '');
                validateProductLine();
                updateProductTotal();
            });

            lineDiv.querySelector('.removeLineBtn').addEventListener('click', () => {
                lineDiv.remove();
                updateProductTotal();
            });

            function validateProductLine() {
                const opt = selectEl.selectedOptions[0];
                if (!opt) {
                    stockLabel.textContent = 'Всего на складе: ---';
                    errorMsg.textContent = 'Выберите товар';
                    disableBtn(productSaveBtn, 'Выберите товар');
                    return;
                }
                const stock = +opt.dataset.amount;
                const unit = opt.dataset.unit;
                stockLabel.textContent = `Всего на складе: ${stock} (${unit})`;

                let val = parseInt(inputEl.value, 10);
                if (isNaN(val) || val < 1) {
                    errorMsg.textContent = 'Минимум 1';
                    disableBtn(productSaveBtn, 'Минимум 1');
                    return;
                }
                if (val > stock) {
                    errorMsg.textContent = `Максимум ${stock}`;
                    inputEl.value = stock;
                    disableBtn(productSaveBtn, `Максимум ${stock}`);
                    return;
                }
                errorMsg.textContent = '';
                enableBtn(productSaveBtn);
            }

            function disableBtn(btn, text) {
                btn.disabled = true;
                btn.textContent = text;
                btn.style.cursor = 'not-allowed';
                btn.style.backgroundColor = '#D33B4C';
            }

            function enableBtn(btn, text = 'Сохранить') {
                btn.disabled = false;
                btn.textContent = text;
                btn.style.cursor = 'pointer';
                btn.style.backgroundColor = '#707FDD';
            }
        }

        function updateProductTotal() {
            let total = 0;
            document.querySelectorAll('.product-line').forEach(line => {
                const sel = line.querySelector('.productSelect');
                const inp = line.querySelector('.productAmountInput');
                const opt = sel.selectedOptions[0];
                if (!opt) return;
                total += (+opt.dataset.price) * (+inp.value || 0);
            });
            productTotalElem.textContent = `${total} руб`;
        }

        function addProductLine() {
            const idx = productLineIndex++;
            const div = document.createElement('div');
            div.className = 'product-line';
            div.dataset.index = idx;
            div.innerHTML = `
            <div class="product-line-good">
                <label>Товар</label>
                <select name="products[${idx}][product_warehouse]" class="productSelect"></select>
            </div>
            <div class="product-line-count">
                <label>Кол-во</label>
                <input type="number" name="products[${idx}][amount]" class="productAmountInput" value="1" min="1">
            </div>
            <div class="product-line-btn">
                <label class="warehouseStockLabel">Всего на складе:</label>
                <button type="button" class="removeLineBtn">
                    <img src="/assets/themes/Carwashing/img/trash-icon.svg" alt="">
                </button>
            </div>`;
            productLinesContainer.appendChild(div);
            initializeProductLine(div, idx);
            updateProductTotal();
        }

        addProductBtn.addEventListener('click', addProductLine);
        const firstProd = productLinesContainer.querySelector('.product-line');
        if (firstProd) {
            initializeProductLine(firstProd, 0);
            productLineIndex = 1;
        } else addProductLine();
        updateProductTotal();

        /* ================================
           Логика для услуг (Автомойка)
           ================================ */
        function fillServiceSelect(selectEl) {
            selectEl.innerHTML = '<option disabled selected>Выбрать услугу</option>';
            servicesJS.forEach(srv => {
                const opt = document.createElement('option');
                opt.value = srv.id;
                opt.textContent = srv.name;
                opt.dataset.price = srv.price;
                selectEl.appendChild(opt);
            });
        }

        function initializeServiceLine(lineDiv, idx) {
            const selectEl = lineDiv.querySelector('.serviceSelect');
            const errorMsg = document.createElement('div');
            errorMsg.className = 'input-error';
            errorMsg.style.color = 'red';
            lineDiv.appendChild(errorMsg);

            fillServiceSelect(selectEl);
            $(selectEl).select2({
                placeholder: 'Выбрать услугу',
                allowClear: true,
                width: 'auto',
                language: {
                    noResults: () => 'Услуга не найдена'
                }
            }).on('change', () => {
                validateServiceLine();
                updateServiceTotal();
            });

            lineDiv.querySelector('.removeServiceBtn').addEventListener('click', () => {
                lineDiv.remove();
                updateServiceTotal();
            });

            function validateServiceLine() {
                const opt = selectEl.selectedOptions[0];
                if (!opt) {
                    errorMsg.textContent = 'Выберите услугу';
                    return;
                }
                errorMsg.textContent = '';
            }
        }

        function updateServiceTotal() {
            let sum = 0;
            const percent = +classSelect.value ? +classSelect.selectedOptions[0].dataset.percent : 0;

            document.querySelectorAll('.service-line').forEach(line => {
                const opt = line.querySelector('.serviceSelect')?.selectedOptions[0];
                if (!opt) return;
                const basePrice = +opt.dataset.price;
                const markup = percent;
                sum += basePrice + markup;
            });

            serviceTotalElem.textContent = `${Math.round(sum)} руб`;
        }

        function addServiceLine() {
            const idx = serviceLineIndex++;
            const div = document.createElement('div');
            div.className = 'service-line';
            div.dataset.index = idx;
            div.innerHTML = `
            <div class="service-line-service">
                <label>Услуга</label>
                <select name="services[${idx}][service_id]" class="serviceSelect" style="width:auto;"></select>
            </div>
            <div class="service-line-btn">
                <label>ㅤ</label>
                <button type="button" class="removeServiceBtn">
                    <img src="/assets/themes/Carwashing/img/trash-icon.svg" alt="">
                </button>
            </div>`;
            serviceLinesContainer.appendChild(div);
            initializeServiceLine(div, idx);
            updateServiceTotal();
        }

        addServiceBtn.addEventListener('click', addServiceLine);
        classSelect.addEventListener('change', updateServiceTotal);
        const firstServ = serviceLinesContainer.querySelector('.service-line');
        if (firstServ) {
            initializeServiceLine(firstServ, 0);
            serviceLineIndex = 1;
        } else addServiceLine();
        updateServiceTotal();
    });
</script>


<?php $render->component('dashboard_footer'); ?>