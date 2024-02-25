<?php

/**
 * @var \Core\Render $render
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
                <tr class="users-table-row">
                    <td class="users-table-column-id" id="copy-to-clipboard"> 1</td>
                    <td class="users-table-column-role">Гей лорд</td>
                    <td class="users-table-column-name">Данила</td>
                    <td class="users-table-column-login">lublusosat</td>
                    <td class="users-table-column-email">lublusosat@mail.chpok
                        <div>
                            <button class="users-table-edit-user" type="submit"><img src="/assets/themes/Basic/img/edit-icon.svg" alt=""></button>
                            <button class="users-table-delete-user" type="submit"><img src="/assets/themes/Basic/img/delete-icon.svg" alt=""></button>
                        </div>
                    </td>
                </tr>
                <tr class="users-table-row">
                    <td class="users-table-column-id"> 1</td>
                    <td class="users-table-column-role">Гей лорд</td>
                    <td class="users-table-column-name">Данила</td>
                    <td class="users-table-column-login">lublusosat</td>
                    <td class="users-table-column-email">lublusosat@mail.chpok
                        <div>
                            <button class="users-table-edit-user" type="submit"><img src="/assets/themes/Basic/img/edit-icon.svg" alt=""></button>
                            <button class="users-table-delete-user" type="submit"><img src="/assets/themes/Basic/img/delete-icon.svg" alt=""></button>
                        </div>
                    </td>
                </tr>
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
                    <option href="#" onclick="selectRole('Администратор')">Администратор</option>
                    <option href="#" onclick="selectRole('Модератор')">Модератор</option>
                    <option href="#" onclick="selectRole('Пользователь')">Пользователь</option>
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
                    </tr>
                </thead>
                <tbody class="users-role-table-body">
                    <tr class="users-role-table-row">
                        <td class="users-role-table-column-id" id="copy-to-clipboard"> 1</td>
                        <td class="users-role-table-column-role">Администратор</td>
                        <td class="users-role-table-column-permissions">1
                            <div>
                                <button class="users-role-table-edit-user" type="submit"><img src="./assets/img/settings.svg" alt=""></button>
                                <button class="users-role-table-delete-user" type="submit"><img src="./assets/img/delete-icon.svg" alt=""></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="users-role-table-row">
                        <td class="users-role-table-column-id" id="copy-to-clipboard"> 2</td>
                        <td class="users-role-table-column-role">Модератор</td>
                        <td class="users-role-table-column-permissions">2
                            <div>
                                <button class="users-role-table-edit-user" type="submit"><img src="./assets/img/settings.svg" alt=""></button>
                                <button class="users-role-table-delete-user" type="submit"><img src="./assets/img/delete-icon.svg" alt=""></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="users-role-table-row">
                        <td class="users-role-table-column-id" id="copy-to-clipboard"> 3</td>
                        <td class="users-role-table-column-role">Пользователь</td>
                        <td class="users-role-table-column-permissions">3
                            <div>
                                <button class="users-role-table-edit-user" type="submit"><img src="./assets/img/settings.svg" alt=""></button>
                                <button class="users-role-table-delete-user" type="submit"><img src="./assets/img/delete-icon.svg" alt=""></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="users-role-table-row">
                        <td class="users-role-table-column-id" id="copy-to-clipboard"> 4</td>
                        <td class="users-role-table-column-role">Гость</td>
                        <td class="users-role-table-column-permissions">4
                            <div>
                                <button class="users-role-table-edit-user" type="submit"><img src="./assets/img/settings.svg" alt=""></button>
                                <button class="users-role-table-delete-user" type="submit"><img src="./assets/img/delete-icon.svg" alt=""></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="users-add-role">
            <h3 class="users-add-role-title">Добавить роль</h3>
            <input type="text" class="users-information">
            <select name="role" id="">
                <option href="#" onclick="selectRole('Администратор')">Администратор</option>
                <option href="#" onclick="selectRole('Модератор')">Модератор</option>
                <option href="#" onclick="selectRole('Пользователь')">Пользователь</option>
                <option href="#" onclick="selectRole('Гость')">Гость</option>
            </select>
        </div>
    </div>
</div>
<?php $render->component('dashboard_footer'); ?>