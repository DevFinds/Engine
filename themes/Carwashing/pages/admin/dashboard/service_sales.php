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
                // Пример: productsJS — массив с товарами (id, name, sale_price, ...).
                // Его можно сгенерировать в PHP: json_encode($products).
                const productsJS = <?php echo json_encode($products, JSON_UNESCAPED_UNICODE); ?>;
            </script>

            <form id="cafeContainer"
                action="/admin/dashboard/service_sales/addNewProductSale"
                method="post"
                style="display: block;">

                <!-- Контейнер для списка позиций -->
                <div id="productLinesContainer">
                    <!-- Пример одной строки (шаблон) -->
                    <div class="product-line" data-index="0">
                        <label>Товар:</label>
                        <select name="products[0][product_id]" class="productSelect" style="width: 300px;"></select>

                        <label>Кол-во:</label>
                        <input type="number" name="products[0][amount]" class="productAmountInput" value="1" min="1" style="width: 100px;">

                        <button type="button" class="removeLineBtn" style="padding: 8px 16px; background-color: #F05B5B; color: white; border: none; border-radius: 8px;">X</button>
                    </div>
                </div>

                <!-- Кнопка добавления новой строки -->
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
        // 1. Селекторы
        const productLinesContainer = document.getElementById('productLinesContainer');
        const addLineBtn = document.getElementById('addLineBtn');
        const totalAmountElem = document.getElementById('productTotal');

        // 2. Инициализация Select2 на уже имеющейся строке (индекс 0)
        initializeLine(productLinesContainer.querySelector('.product-line'), 0);

        // 3. Обработчик добавления новой строки
        let lineIndex = 1; // следующий индекс для новой строки
        addLineBtn.addEventListener('click', function() {
            // Создаем div.product-line
            const lineDiv = document.createElement('div');
            lineDiv.className = 'product-line';
            lineDiv.setAttribute('data-index', lineIndex);

            // Формируем HTML для select и input
            lineDiv.innerHTML = `
            <label>Товар:</label>
            <select name="products[${lineIndex}][product_id]" class="productSelect" style="width: 300px;"></select>

            <label>Кол-во:</label>
            <input type="number" name="products[${lineIndex}][amount]" class="productAmountInput" value="1" min="1" style="width: 100px;">

            <button type="button" class="removeLineBtn" style="padding: 8px 16px; background-color: #F05B5B; color: white; border: none; border-radius: 8px;">X</button>
        `;

            // Вставляем в контейнер
            productLinesContainer.appendChild(lineDiv);

            // Инициализируем Select2 + привязка обработчиков
            initializeLine(lineDiv, lineIndex);

            lineIndex++;
        });

        // 4. Функция инициализации строки:
        function initializeLine(lineDiv, index) {
            // Найдём select
            const selectEl = lineDiv.querySelector('.productSelect');
            const amountEl = lineDiv.querySelector('.productAmountInput');
            const removeBtn = lineDiv.querySelector('.removeLineBtn');

            // Заполним select опциями из productsJS
            fillSelectWithProducts(selectEl);

            // Подключим Select2
            $(selectEl).select2({
                placeholder: 'Выбрать товар',
                allowClear: true,
                language: {
                    noResults: function() {
                        return 'Товар не найден';
                    }
                }
            });

            // При изменении select или amount → пересчитываем итог
            $(selectEl).on('change', updateTotalPrice);
            amountEl.addEventListener('input', updateTotalPrice);

            // Удаление строки
            removeBtn.addEventListener('click', function() {
                lineDiv.remove();
                updateTotalPrice(); // пересчитать после удаления
            });
        }

        // 5. Функция заполнения <select> опциями
        function fillSelectWithProducts(selectEl) {
            // Очищаем сначала
            selectEl.innerHTML = '<option disabled selected>Выбрать товар</option>';
            // Заполняем
            productsJS.forEach(product => {
                const opt = document.createElement('option');
                opt.value = product.id; // Сохраняем id (на сервере будем искать этот товар)
                opt.textContent = product.name;
                // никаких data-price не храним, т.к. будем использовать productsJS массив
                selectEl.appendChild(opt);
            });
        }

        // 6. Функция пересчёта общей суммы по всем строкам
        function updateTotalPrice() {
            let total = 0;

            // Перебираем все .product-line
            document.querySelectorAll('.product-line').forEach(line => {
                const selectEl = line.querySelector('.productSelect');
                const amountEl = line.querySelector('.productAmountInput');

                const productId = selectEl.value;
                const amount = parseFloat(amountEl.value) || 1;

                // Ищем объект товара в productsJS
                const productObj = productsJS.find(p => String(p.id) === productId);
                if (productObj) {
                    const price = parseFloat(productObj.sale_price) || 0;
                    total += price * amount;
                }
            });

            totalAmountElem.textContent = `${total} руб`;
        }

        // 7. При загрузке страницы считаем итог, если нужно
        updateTotalPrice();
    });
</script>



<?php $render->component('dashboard_footer'); ?>