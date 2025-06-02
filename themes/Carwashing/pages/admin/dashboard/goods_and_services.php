<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 * @var \Core\Event\EventManager $eventManager
 */

// Поставщики
$company_service = $data['company_service'];
$suppliers = $company_service->getCompanyByType(2);
$suppliers_service = $data['suppliers_service'];
$suppliers = $suppliers_service->getAllFromDB();
// Склады
$warehouse_service = $data['warehouse_service'];
$warehouses = $warehouse_service->getAllFromDB();
// Товары
$product_service = $data['product_service'];
$products = $product_service->getAllFromDBAllSuppliers();

// Услуги
$service_service = $data['service_service'];
$services = $service_service->getAllFromDB();

$user = $this->auth->getUser();
?>

<?php $render->component('dashboard_header'); ?>
<?php $render->component('menu_sidebar'); ?>

<!-- Тело страницы -->
<div class="page-content-container">
    <div class="page-content">
        <?php $render->component('pagecontent_header'); ?>
        <div class="page-content-body">
            <div class="tabs-container">
                <div class="tabs">
                    <div class="tab active" data-tab="goods" onclick="switchTab('goods')">Товары</div>
                    <div class="tab" data-tab="services" onclick="switchTab('services')">Услуги</div>
                </div>
            </div>

            <!-- Вкладка товаров -->
            <div class="tab-content" id="goodsContainer">
                <div class="create-goods-container">
                    <p>Создать позицию товара</p>
                    <?php if ($session->has('error')): ?>
                        <p style="color: red;"><?php echo $session->get('error');
                                                $session->remove('error'); ?></p>
                    <?php endif; ?>
                    <?php foreach (['name', 'amount', 'created_at', 'unit_measurement', 'purchase_price', 'sale_price', 'supplier_id', 'warehouse_id'] as $field): ?>
                        <?php if ($session->has($field)): ?>
                            <p style="color: red;"><?php echo implode(', ', $session->get($field));
                                                    $session->remove($field); ?></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <form class="goods-form-section" action="/admin/dashboard/goods_and_services/addNewGood" method="post">
                        <div class="goods-form-main-fields">
                            <label class="goods-form-main-fields-label">Основные поля</label>
                            <div class="goods-form-main-fields-inputs">
                                <ul class="goods-form-main-fields-column">
                                    <li><input type="text" name="name" placeholder="Название" required></li>
                                    <li><input type="number" name="amount" placeholder="Количество" required></li>
                                </ul>
                                <ul class="goods-form-main-fields-column">
                                    <li><input type="date" name="created_at" placeholder="Дата добавления" required></li>
                                    <li>
                                        <select class="goods-form-unit-measurement-select" name="unit_measurement" required>
                                            <option disabled selected>Ед. изм.</option>
                                            <option value="шт.">Шт.</option>
                                            <option value="кг.">Кг.</option>
                                            <option value="л.">Л.</option>
                                            <option value="м.">М.</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="goods-form-buy-and-sell-fields">
                            <label class="goods-form-buy-and-sell-fields-label">Закупка и продажа</label>
                            <div class="goods-form-buy-and-sell-fields-inputs">
                                <li><input type="number" name="purchase_price" placeholder="Стоимость закупки" required></li>
                                <li><input type="number" name="sale_price" placeholder="Стоимость продажи" required></li>
                            </div>
                        </div>
                        <div class="goods-form-information">
                            <label class="goods-form-information-label">Информация о поставщике</label>
                            <div class="goods-form-information-selects">
                                <li>
                                    <select class="goods-form-provider-select" name="supplier_id" required>
                                        <option disabled selected>Поставщик</option>
                                        <?php foreach ($suppliers as $supplier) : ?>
                                            <option value="<?php echo $supplier->id(); ?>"><?= $supplier->name(); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </li>
                                <li>
                                    <select class="goods-form-storage-select" name="warehouse_id" required>
                                        <option disabled selected>На склад</option>
                                        <?php foreach ($warehouses as $warehouse => $warehouseData) : ?>
                                            <option value="<?= $warehouseData['id'] ?>"><?= $warehouseData['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </li>
                            </div>
                            <div class="goods-form-note-section">
                                <button type="button" class="goods-form-note-button" onclick="toggleNoteField('note-field-goods-and-services')">Добавить примечание</button>
                                <div class="goods-form-note-container" id="note-field-goods-and-services">
                                    <textarea class="goods-form-note-area" name="description" placeholder="Введите комментарий"></textarea>
                                </div>
                            </div>
                            <div class="goods-form-buttons">
                                <button type="submit" class="goods-form-button-save">Сохранить</button>
                                <button type="button" class="goods-form-button-clear">Очистить</button>
                            </div>
                            <?php
                            $data_to_check = ['user_lastname'];
                            foreach ($data_to_check as $data) {
                                if ($session->has($data)) {
                            ?>
                                    <ul class="error-list d-flex flex-column">
                                        <?php foreach ($session->getFlash($data, 'nothing') as $error) { ?>
                                            <span class="register-error-message"><?php echo $error; ?></span>
                                        <?php } ?>
                                    </ul>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </form>

                    <div class="financial-accounting-first__list-container">
                        <label class="financial-accounting-first__list-label">Добавленные позиции</label>
                        <div class="financial-accounting-first__list">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Наименование</th>
                                        <th>Закупка, ₽</th>
                                        <th>Продажа, ₽</th>
                                        <th>Склад</th>
                                        <th>Поставщик</th>
                                        <th>Дата</th>
                                        <th>Кол-во</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product => $productData) : ?>
                                        <tr data-type="product" data-unit-measurement="<?php echo htmlspecialchars($productData['unit_measurement']); ?>" data-description="<?php echo htmlspecialchars($productData['description'] ?? ''); ?>">
                                            <td><?php echo $productData['id']; ?></td>
                                            <td><?php echo $productData['name']; ?></td>
                                            <td><?php echo $productData['purchase_price']; ?></td>
                                            <td><?php echo $productData['sale_price']; ?></td>
                                            <td><?php
                                                $warehouse_id = intval($productData['warehouse_id']) - 1;
                                                $supplier_id = intval($productData['supplier_id']) - 1;
                                                echo $warehouses[$warehouse_id]['name']; ?></td>
                                            <td><?php echo $suppliers[$supplier_id]->name(); ?></td>
                                            <td><?php echo $productData['created_at']; ?></td>
                                            <td><?php echo $productData['amount']; ?></td>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Вкладка услуг -->
            <div class="tab-content" id="servicesContainer" style="display: none;">
                <div class="create-goods-container">
                    <p>Создать позицию услуги</p>
                    <?php if ($session->has('error')): ?>
                        <p style="color: red;"><?php echo $session->get('error');
                                                $session->remove('error'); ?></p>
                    <?php endif; ?>
                    <?php foreach (['name', 'price', 'category'] as $field): ?>
                        <?php if ($session->has($field)): ?>
                            <p style="color: red;"><?php echo implode(', ', $session->get($field));
                                                    $session->remove($field); ?></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <form class="goods-form-section" action="/admin/dashboard/goods_and_services/addNewService" method="post">
                        <div class="goods-form-main-fields">
                            <label class="goods-form-main-fields-label">Основные поля</label>
                            <div class="goods-form-main-fields-inputs">
                                <ul class="goods-form-main-fields-column">
                                    <li><input type="text" placeholder="Категория" name="category" required></li>
                                </ul>
                                <ul class="goods-form-main-fields-column">
                                    <li><input type="number" placeholder="Стоимость услуги" name="price" required></li>
                                </ul>
                            </div>
                            <div class="goods-form-main-fields-inputs">
                                <input type="text" name="name" placeholder="Наименование услуги" required>
                            </div>
                        </div>
                        <div class="goods-form-note-section">
                            <button type="button" class="goods-form-note-button" onclick="toggleNoteField('note-field-services')">Добавить примечание</button>
                            <div class="goods-form-note-container" id="note-field-services">
                                <textarea name="description" class="goods-form-note-area" placeholder="Введите комментарий"></textarea>
                            </div>
                        </div>
                        <div class="goods-form-buttons">
                            <button type="submit" class="goods-form-button-save">Сохранить</button>
                            <button type="button" class="goods-form-button-clear">Очистить</button>
                        </div>
                    </form>

                    <div class="financial-accounting-first__list-container">
                        <label class="financial-accounting-first__list-label">Добавленные позиции</label>
                        <div class="financial-accounting-first__list">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Наименование</th>
                                        <th>Стоимость, ₽</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($services as $service => $serviceData) : ?>
                                        <tr data-type="service" data-category="<?php echo htmlspecialchars($serviceData->category()); ?>" data-description="<?php echo htmlspecialchars($serviceData->description() ?? ''); ?>">
                                            <td><?php echo $serviceData->id(); ?></td>
                                            <td><?php echo $serviceData->name(); ?></td>
                                            <td><?php echo $serviceData->price(); ?></td>
                                            <td>
                                                <button class="financial-accounting-first__edit-button" data-type="service">
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7159 4.9375C10.7159 4.62684 10.4641 4.375 10.1534 4.375H2.6875C1.75552 4.375 1 5.13052 1 6.0625V17.3125C1 18.2445 1.75552 19 2.6875 19H13.9375C14.8695 19 15.625 18.2445 15.625 17.3125V9.84659C15.625 9.53593 15.3732 9.28409 15.0625 9.28409C14.7518 9.28409 14.5 9.53593 14.5 9.84659V17.3125C14.5 17.6232 14.2482 17.875 13.9375 17.875H2.6875C2.37684 17.875 2.125 17.6232 2.125 17.3125V6.0625C2.125 5.75184 2.37684 5.5 2.6875 5.5H10.1534C10.4641 5.5 10.7159 5.24816 10.7159 4.9375Z" fill="#707FDD" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19 1.5625C19 1.25184 18.7482 1 18.4375 1H12.8125C12.5018 1 12.25 1.25184 12.25 1.5625C12.25 1.87316 12.5018 2.125 12.8125 2.125H17.0795L7.91475 11.2898C7.69508 11.5094 7.69508 11.8656 7.91475 12.0852C8.13442 12.3049 8.49058 12.3049 8.71025 12.0852L17.875 2.9205V7.1875C17.875 7.49816 18.1268 7.75 18.4375 7.75C18.7482 7.75 19 7.49816 19 7.1875V1.5625Z" fill="#707FDD" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Модальное окно для товаров -->
            <div id="editProductModal" class="goods-services-modal" style="display: none;">
                <div class="goods-services-modal-content">
                    <span class="goods-services-close-button">×</span>
                    <h2>Редактировать товар</h2>
                    <form id="editProductForm" method="post" action="/admin/dashboard/goods_and_services/editProduct">
                        <input type="hidden" name="id" id="productId">
                        <div class="modal-two-columns">
                            <div class="modal-column">
                                <label for="productName">Наименование</label>
                                <input type="text" name="name" id="productName" required>
                                <label for="productAmount">Количество</label>
                                <input type="number" name="amount" id="productAmount" required>
                                <label for="productCreatedAt">Дата создания</label>
                                <input type="date" name="created_at" id="productCreatedAt" required>
                                <label for="productUnitMeasurement">Ед. изм.</label>
                                <select name="unit_measurement" id="productUnitMeasurement" required>
                                    <option value="шт.">Шт.</option>
                                    <option value="кг.">Кг.</option>
                                    <option value="л.">Л.</option>
                                    <option value="м.">М.</option>
                                </select>
                            </div>
                            <div class="modal-column">
                                <label for="productPurchasePrice">Цена закупки</label>
                                <input type="number" name="purchase_price" id="productPurchasePrice" required>
                                <label for="productSalePrice">Цена продажи</label>
                                <input type="number" name="sale_price" id="productSalePrice" required>
                                <label for="productSupplierId">Поставщик</label>
                                <select name="supplier_id" id="productSupplierId" required>
                                    <?php foreach ($suppliers as $supplier) : ?>
                                        <option value="<?php echo $supplier->id(); ?>"><?php echo $supplier->name(); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="productWarehouseId">Склад</label>
                                <select name="warehouse_id" id="productWarehouseId" required>
                                    <?php foreach ($warehouses as $warehouse => $warehouseData) : ?>
                                        <option value="<?php echo $warehouseData['id']; ?>"><?php echo $warehouseData['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <label for="productDescription">Примечание</label>
                        <textarea name="description" id="productDescription"></textarea>
                        <div class="modal-buttons">
                            <button type="submit">Сохранить</button>
                            <button type="button" id="deleteProductButton">Удалить</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Модальное окно для услуг -->
            <div id="editServiceModal" class="goods-services-modal" style="display: none;">
                <div class="goods-services-modal-content">
                    <span class="goods-services-close-button">×</span>
                    <h2>Редактировать услугу</h2>
                    <form id="editServiceForm" method="post" action="/admin/dashboard/goods_and_services/editService">
                        <input type="hidden" name="id" id="serviceId">
                        <div class="modal-two-columns">
                            <div class="modal-column">
                                <label for="serviceName">Наименование</label>
                                <input type="text" name="name" id="serviceName" required>
                                <label for="servicePrice">Стоимость</label>
                                <input type="number" name="price" id="servicePrice" required>
                            </div>
                            <div class="modal-column">
                                <label for="serviceCategory">Категория</label>
                                <input type="text" name="category" id="serviceCategory" required>
                            </div>
                        </div>
                        <label for="serviceDescription">Примечание</label>
                        <textarea name="description" id="serviceDescription"></textarea>
                        <div class="modal-buttons">
                            <button type="submit">Сохранить</button>
                            <button type="button" id="deleteServiceButton">Удалить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.financial-accounting-first__edit-button');
        const productModal = document.getElementById('editProductModal');
        const serviceModal = document.getElementById('editServiceModal');
        const closeButtons = document.querySelectorAll('.goods-services-close-button');
        const deleteProductButton = document.getElementById('deleteProductButton');
        const deleteServiceButton = document.getElementById('deleteServiceButton');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const type = row.getAttribute('data-type');

                if (type === 'product') {
                    const id = row.cells[0].textContent;
                    const name = row.cells[1].textContent;
                    const purchasePrice = row.cells[2].textContent;
                    const salePrice = row.cells[3].textContent;
                    const warehouseId = row.cells[4].textContent;
                    const supplierId = row.cells[5].textContent;
                    const createdAt = row.cells[6].textContent;
                    const amount = row.cells[7].textContent;
                    const unitMeasurement = row.getAttribute('data-unit-measurement') || 'шт.';
                    const description = row.getAttribute('data-description') || '';

                    document.getElementById('productId').value = id;
                    document.getElementById('productName').value = name;
                    document.getElementById('productAmount').value = amount;
                    document.getElementById('productCreatedAt').value = createdAt;
                    document.getElementById('productUnitMeasurement').value = unitMeasurement;
                    document.getElementById('productPurchasePrice').value = purchasePrice;
                    document.getElementById('productSalePrice').value = salePrice;
                    document.getElementById('productSupplierId').value = supplierId;
                    document.getElementById('productWarehouseId').value = warehouseId;
                    document.getElementById('productDescription').value = description;

                    productModal.style.display = 'block';
                } else if (type === 'service') {
                    const id = row.cells[0].textContent;
                    const name = row.cells[1].textContent;
                    const price = row.cells[2].textContent;
                    const category = row.getAttribute('data-category') || '';
                    const description = row.getAttribute('data-description') || '';

                    document.getElementById('serviceId').value = id;
                    document.getElementById('serviceName').value = name;
                    document.getElementById('servicePrice').value = price;
                    document.getElementById('serviceCategory').value = category;
                    document.getElementById('serviceDescription').value = description;

                    serviceModal.style.display = 'block';
                }
            });
        });

        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                productModal.style.display = 'none';
                serviceModal.style.display = 'none';
            });
        });

        window.addEventListener('click', function(event) {
            if (event.target === productModal) productModal.style.display = 'none';
            if (event.target === serviceModal) serviceModal.style.display = 'none';
        });

        deleteProductButton.addEventListener('click', function() {
            const productId = document.getElementById('productId').value;
            console.log('Deleting product with ID:', productId);
            if (!productId) {
                alert('Ошибка: ID товара не указан');
                return;
            }
            if (confirm('Вы уверены, что хотите удалить этот товар?')) {
                const button = this;
                button.disabled = true; // Отключаем кнопку
                fetch('/admin/dashboard/goods_and_services/deleteProduct', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: productId
                        })
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.text().then(text => ({
                            text,
                            response
                        }));
                    })
                    .then(({
                        text,
                        response
                    }) => {
                        console.log('Raw response:', text);
                        if (!text) {
                            throw new Error('Пустой ответ от сервера');
                        }
                        return JSON.parse(text);
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            location.reload();
                        } else {
                            alert('Ошибка при удалении товара: ' + (data.message || 'Неизвестная ошибка'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ошибка при удалении товара: ' + error.message);
                    })
                    .finally(() => {
                        button.disabled = false; // Включаем кнопку
                    });
            }
        });

        deleteServiceButton.addEventListener('click', function() {
            const serviceId = document.getElementById('serviceId').value;
            console.log('Deleting service with ID:', serviceId);
            if (!serviceId) {
                alert('Ошибка: ID услуги не указан');
                return;
            }
            if (confirm('Вы уверены, что хотите удалить эту услугу?')) {
                fetch('/admin/dashboard/goods_and_services/deleteService', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: serviceId
                        })
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.text().then(text => ({
                            text,
                            response
                        }));
                    })
                    .then(({
                        text,
                        response
                    }) => {
                        console.log('Raw response:', text);
                        if (!text) {
                            throw new Error('Пустой ответ от сервера');
                        }
                        return JSON.parse(text);
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            location.reload();
                        } else {
                            alert('Ошибка при удалении услуги: ' + (data.message || 'Неизвестная ошибка'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ошибка при удалении услуги: ' + error.message);
                    });
            }
        });

        window.switchTab = function(tab) {
            document.getElementById('goodsContainer').style.display = tab === 'goods' ? 'block' : 'none';
            document.getElementById('servicesContainer').style.display = tab === 'services' ? 'block' : 'none';
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelector(`.tab[data-tab="${tab}"]`).classList.add('active');
        };

        window.toggleNoteField = function(id) {
            const field = document.getElementById(id);
            field.style.display = field.style.display === 'none' ? 'block' : 'none';
        };
    });
</script>

<?php $render->component('dashboard_footer'); ?>