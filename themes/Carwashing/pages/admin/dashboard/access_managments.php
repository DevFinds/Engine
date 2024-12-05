<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 */

$roles = $this->auth->getRoleList();
?>

<?php $render->component('dashboard_header'); ?>
<!-- Сайдбар с меню -->
    <?php $render->component('menu_sidebar'); ?>
    <!-- Тело страницы -->
    <!-- Контейнер с содержимым страницы -->
    <div class="page-content-container">
        <!-- Содержимое страницы -->
        <div class="page-content">

            <!-- Header страницы -->
            <div class="page-content-header">

<!-- Хлебные крошки -->
<div class="breadcrumbs-container">
    <a href="" class="breadcrumb-previous">Страницы</a>
    <span class="breadcrumb-separator">/</span>
    <a href="" class="breadcrumb-current">Управление компанией</a>
</div>

<!-- Пользователь -->
<div class="user-container">
    <img src="./assets/img/avatar.png" class="user-avatar" alt="">
    <span class="username">Иван Иванов</span>
    <svg class="user-menu-icon" width="10" height="6" viewBox="0 0 10 6" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        
</div>
</div>


<!-- Содержимое страницы -->
<div class="page-content-body">

<div class="tabs-container">

    <div class="tabs">
        <div class="tab active" data-tab="role-list" onclick="switchTab('role-list')">Список ролей</div>
        <div class="tab" data-tab="role-add" onclick="switchTab('role-add')">Добавить роль</div>
    </div>
</div>

<div class="tab-content" id="role-listContainer">
    <div class="employees-tab-container">
        <label class="financial-accounting-first-label">Список ролей</label>
        <div class="financial-accounting-first__list role__list">
            <table>
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th style="display: flex; justify-content: center;">Уровень привелегий</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $role => $role_data): ?>
                    <tr>
                    <td><?php echo $role_data['role_id']; ?></td>
                    <td><?php echo $role_data['role_name']; ?></td>
                    <td style="display: flex; justify-content: center;"><?php echo $role_data['role_perm_level']; ?></td>
                    <td>
                        <button class="financial-accounting-first__edit-button">
                            <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.22908 1.27236C7.86788 0.0469086 6.13212 0.0469091 5.77092 1.27236L5.68333 1.56955C5.45254 2.35256 4.55818 2.72301 3.84132 2.33253L3.56924 2.18433C2.44731 1.57321 1.21994 2.80058 1.83106 3.92251L1.97926 4.19459C2.36974 4.91146 1.99929 5.80581 1.21628 6.0366L0.919088 6.12419C-0.306363 6.48539 -0.306362 8.22115 0.919088 8.58235L1.21628 8.66995C1.99929 8.90074 2.36974 9.79509 1.97926 10.512L1.83106 10.784C1.21994 11.906 2.44731 13.1333 3.56924 12.5222L3.84132 12.374C4.55818 11.9835 5.45254 12.354 5.68333 13.137L5.77092 13.4342C6.13212 14.6596 7.86788 14.6596 8.22908 13.4342L8.31668 13.137C8.54747 12.354 9.44182 11.9835 10.1587 12.374L10.4308 12.5222C11.5527 13.1333 12.7801 11.906 12.1689 10.784L12.0207 10.512C11.6303 9.79509 12.0007 8.90074 12.7837 8.66995L13.0809 8.58235C14.3064 8.22115 14.3064 6.48539 13.0809 6.12419L12.7837 6.0366C12.0007 5.80581 11.6303 4.91146 12.0207 4.19459L12.1689 3.92251C12.7801 2.80058 11.5527 1.57321 10.4308 2.18433L10.1587 2.33253C9.44182 2.72301 8.54747 2.35256 8.31668 1.56955L8.22908 1.27236ZM7 9.91598C5.58465 9.91598 4.43729 8.76862 4.43729 7.35327C4.43729 5.93793 5.58465 4.79056 7 4.79056C8.41535 4.79056 9.56271 5.93793 9.56271 7.35327C9.56271 8.76862 8.41535 9.91598 7 9.91598Z" fill=""/>
                                </svg>                                                    
                        </button>
                    </td>
                    </tr>
                    <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>


<div class="tab-content" id="role-addContainer">
    <div class="act-checking-tab-container">
        <label class="financial-accounting-first-label">Создание роли</label>

    <div class = "financial-accounting-first-container" id="actChecking">
        <div class="financial-accounting-first__create">
            <div class="financial-accounting-first__create-forms">
                <ul class="financial-accounting-first__create-first-column">
                    <li><input type="number" placeholder="ID"></li>
                </ul>
                <ul class="financial-accounting-first__create-second-column">
                    <li><input type="number" placeholder="Сумма, ₽"></li>
                </ul>
            </div>
            <select class="financial-accounting-first__create-select">
                <option disabled selected>Контрагент</option>
            </select>
        <div class="financial-accounting-first__buttons">
            <button class="financial-accounting-first__button-save">Добавить</button>
        </div>
    </div>
</div>
</div>

</div>
</div>
        </div>
    </div>
</div>
<?php $render->component('footer'); ?>