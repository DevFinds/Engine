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
                // Пример: servicesJS = [
                //   { id:1, name:"Мойка кузова", price:500 },
                //   { id:2, name:"Химчистка салона", price:2000 },
                //   ...
                // ]
                const servicesJS = <?php echo json_encode($services_array, JSON_UNESCAPED_UNICODE); ?>;
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
                            <label class="about-service-form-label">Испольнитель</label>
                            <select class="about-service-form" name="employee_id" required>
                                <option disabled selected>Выбрать исполнителя</option>
                                <?php foreach ($users as $user_model) : ?>
                                    <option value="<?= $user_model->id() ?>"><?= $user_model->username() ?></option>
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
                                id="carNumberInput"
                                placeholder="A000AA00"
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
                        <div class="total-amount-value" id="serviceTotal">0 руб</div>
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
                        <div class="total-amount-value" id="productTotal">0 руб</div>
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
  // Ссылки на обе формы
  const productLinesContainer = document.getElementById('productLinesContainer');
  const addProductBtn         = document.getElementById('addLineBtn');
  const productSaveBtn        = document.getElementById('saveLineBtn');
  const productTotalElem      = document.getElementById('productTotal');

  const serviceLinesContainer = document.getElementById('servicesLinesContainer');
  const addServiceBtn         = document.getElementById('addServiceBtn');
  const serviceTotalElem      = document.getElementById('serviceTotal');

  let productLineIndex = 0;
  let serviceLineIndex = 0;

  // Утилиты для кнопок
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

  /* ================================
     Логика для товаров (Кафе)
     ================================ */
  function fillProductSelect(selectEl) {
    selectEl.innerHTML = '<option disabled selected>Выбрать товар</option>';
    productsJS.forEach(prod => {
      const opt = document.createElement('option');
      opt.value = `${prod.id}_${prod.warehouse_id}`;
      opt.textContent = `${prod.name} [склад ${prod.warehouse_id}]`;
      opt.dataset.price  = prod.sale_price;
      opt.dataset.amount = prod.amount;
      opt.dataset.unit   = prod.unit_measurement;
      selectEl.appendChild(opt);
    });
  }

  function initializeProductLine(lineDiv, idx) {
    const selectEl   = lineDiv.querySelector('.productSelect');
    const inputEl    = lineDiv.querySelector('.productAmountInput');
    const stockLabel = lineDiv.querySelector('.warehouseStockLabel');
    const errorMsg   = document.createElement('div');
    errorMsg.className = 'input-error';
    errorMsg.style.color = 'red';
    inputEl.parentNode.appendChild(errorMsg);

    fillProductSelect(selectEl);
    $(selectEl).select2({
      placeholder: 'Выбрать товар',
      allowClear: true,
      width: '320px',
      language: { noResults: () => 'Товар не найден' }
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
      const unit  = opt.dataset.unit;
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
  }

  function updateProductTotal() {
    let total = 0;
    document.querySelectorAll('.product-line').forEach(line => {
      const sel = line.querySelector('.productSelect');
      const inp = line.querySelector('.productAmountInput');
      const opt = sel.selectedOptions[0];
      if (!opt) return;
      total += (+opt.dataset.price) * (+inp.value||0);
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
  // инициализация первой строки
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
      language: { noResults: () => 'Услуга не найдена' }
    }).on('change', () => {
      updateServiceTotal();
    });

    lineDiv.querySelector('.removeServiceBtn')
      .addEventListener('click', () => {
        lineDiv.remove();
        updateServiceTotal();
      });
  }

  function updateServiceTotal() {
    let sum = 0;
    document.querySelectorAll('.service-line').forEach(line => {
      const opt = line.querySelector('.serviceSelect')?.selectedOptions[0];
      if (!opt) return;
      sum += +opt.dataset.price;
    });
    serviceTotalElem.textContent = `${sum} руб`;
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
  // инициализация первой строки
  const firstServ = serviceLinesContainer.querySelector('.service-line');
  if (firstServ) {
    initializeServiceLine(firstServ, 0);
    serviceLineIndex = 1;
  } else addServiceLine();
  updateServiceTotal();
});
</script>


<?php $render->component('dashboard_footer'); ?>