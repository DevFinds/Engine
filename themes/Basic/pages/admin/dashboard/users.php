<?php

/**
 * @var \Core\Render $render
 * @var array<\Source\Models\User> $users
 * @var array<\Source\Models\Role> $roles
 */
?>
<?php $render->component('dashboard_header'); ?>

<div class="users-bottom-section">
    <div class="users-selector" id="selector">
        <div class="users-selector-buttons">
            <button id="users-user-list-tab">Список пользователей</button>
            <button id="users-create-user-tab">Создать пользователя</button>
            <button id="users-role-editor-tab">Редактор ролей</button>
        </div>
    </div>
    <div class="users-table-container" id="users-table-container">
        <h3 class="users-table-title">Список пользователей</h3>
        <table class="users-table">
            <thead class="users-table-header">
                <tr class="users-table-header-row">
                    <th class="users-table-header-column-id">ID</th>
                    <th class="users-table-header-column-role">Роль</th>
                    <th class="users-table-header-column-name">Имя</th>
                    <th class="users-table-header-column-login">Логин</th>
                    <th class="users-table-header-column-email">Email</th>
                </tr>
            </thead>
            <tbody class="users-table-body">
                <?php
                foreach ($users as $user) { ?>
                    <tr class="users-table-row">
                        <td class="users-table-column-id"> <?= $user->id() ?></td>
                        <td class="users-table-column-role"><?= $user->role() ?></td>
                        <td class="users-table-column-name"><?= $user->username() ?></td>
                        <td class="users-table-column-login"><?= $user->login() ?></td>
                        <td class="users-table-column-email"><?= $user->email() ?>
                            <div>
                                <a class="users-table-edit-user" target="_blank" href="/admin/profile/<?php echo $user->id(); ?>" type="submit"><img src="/assets/themes/Basic/img/edit-icon.svg" alt=""></a>
                                <a class="users-table-delete-user" type="submit"><img src="/assets/themes/Basic/img/delete-icon.svg" alt=""></a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
    <div class="users-create-user-form" id="users-create-user-form">
        <div class="users-create-left-user-form">
            <div class="users-create-avatar-container">
                <div class="users-create-avatar" onclick="insertImage()">
                    <img src="./assets/img/create_avatar.svg" alt="">
                </div>
            </div>
            <div class="users-create-left-input-container">
                <p class="users-create-first-title">Имя</p>
                <input type="text" class="users-information">
                <p class="users-create-next-title">Фамилия</p>
                <input type="text" class="users-information">
            </div>
            <button type="submit" class="users-create-button">Создать</button>
        </div>
        <div class="users-create-right-user-form">
            <p class="users-create-first-title">Логин</p>
            <input type="text" class="users-information">
            <p class="users-create-next-title">Email</p>
            <input type="text" class="users-information">
            <p class="users-create-next-title">Пароль</p>
            <input type="text" class="users-information">
            <p class="users-create-next-title">Роль</p>
            <div class="users-select-wrapper">
                <select name="role" class="users-role-selector">
                    <?php foreach ($roles as $role) { ?>
                        <option href="#" onclick="selectRole('Пользователь')"><?= $role->role_name() ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="users-role-editor" id="users-role-editor">
        <div class="users-list-of-roles">
            <table>
                <thead class="users-role-table-header">
                    <h3 class="users-role-table-title">Список ролей</h3>
                    <tr class="users-role-table-header-row">
                        <th class="users-role-table-header-column-id">ID</th>
                        <th class="users-role-table-header-column-role">Название</th>
                        <th class="users-role-table-header-column-name">Уровень привелегий</th>
                        <th class="users-role-table-header-column-buttons"></th>
                    </tr>
                </thead>
                <tbody class="users-role-table-body">
                    <?php foreach ($roles as $role) { ?>
                        <tr class="users-role-table-row">
                            <td class="users-role-table-column-id" id="copy-to-clipboard"><?php echo $role->role_id() ?></td>
                            <td class="users-role-table-column-role"><?php echo $role->role_name() ?></td>
                            <td class="users-role-table-column-permissions"><?php echo $role->role_perm_level() ?></td>
                            <td class="users-role-table-column-buttons">
                                <div class="users-role-table-column-buttons-wrapper">
                                    <button class="users-role-table-edit-user" type="submit"><img src="/assets/themes/Basic/img/settings.svg" alt=""></button>
                                    <button class="users-role-table-delete-user" type="submit"><img src="/assets/themes/Basic/img/delete-icon.svg" alt=""></button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="users-add-role">
            <h3 class="users-add-role-title">Добавить роль</h3>
            <label>Название</label>
            <input type="text" class="users-name-role-input">
            <label>Уровень привелегий</label>
            <div class="users-select-container">
                <select name="role" id="">
                    <?php foreach ($roles as $role) { ?>
                        <option href="#" onclick="selectRole('Пользователь')"> <span><?php echo $role->role_id(); ?> - </span> <?php echo $role->role_name() ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="users-add-role-button">Добавить</button>
        </div>
    </div>
</div>
<?php $render->component('dashboard_footer'); ?>