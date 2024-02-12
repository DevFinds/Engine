<?php

/**
 * @var \Core\Render $render
 */


?>


<?php $render->component('dashboard_header') ?>
<div class='dashboard-page-container'>
    <div class="dashboard-navbar">
        <img src="/assets/img/dashborad_logo.svg" alt="" class="dashboard-logo">
        <ul class="dashboard-menu">
            <li class="dashboard-menu-item"><img src="/assets/img/general-icon.svg" alt="" class="dashboard-link-icon"><a href="" class="dashboard-menu-link">Основное</a></li>
            <li class="dashboard-menu-item"><img src="/assets/img/user-icon.svg" alt="" class="dashboard-link-icon"><a href="" class="dashboard-menu-link">Пользователи</a></li>
            <li class="dashboard-menu-item"><img src="/assets/img/post-icon.svg" alt="" class="dashboard-link-icon"><a href="" class="dashboard-menu-link">Записи</a></li>
            <li class="dashboard-menu-item"><img src="/assets/img/request-icon.svg" alt="" class="dashboard-link-icon"><a href="" class="dashboard-menu-link">Заявки</a></li>
            <li class="dashboard-menu-item"><img src="/assets/img/setting-icon.svg" alt="" class="dashboard-link-icon"><a href="" class="dashboard-menu-link">Настройки</a></li>
        </ul>
        <div class="dashboard-creator-info">
            <p>Soft by <span class="creator-name">DevFinds</span></p>
            <p class="version">v.1.0</p>
        </div>
    </div>
    <div class="dashboard-right-side">
        <div class="dashboard-header">
            <div class="dashboard-top-section">
                <div class="dashboard-search-container">
                    <img src="/assets/img/loupe.svg" alt="">
                    <input type="text" placeholder="Поиск" class="dashboard-search-input">
                </div>
                <div class="dashboard-user-info">
                    <div class="dashboard-user-button">
                        <img class="dashboard-header-avatar" src="/assets/img/avatar.svg" alt="">
                        <span class="dashboard-username">Имя пользователя
                            <img id="dashboard-collapse-button" class="dashboard-collapse-button" src="/assets/img/collapse.svg" alt="">
                        </span>
                    </div>

                    <div class="dashboard-collapse-menu" id="dashboard-collapse-menu" data-aos="flip-down">
                        <ul>
                            <li><a href=""></a>Аккаунт</li>
                            <li><a href=""></a>Выйти</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <div class="dashboard-bottom-section">
            <div class="dashboard-div-first">block-small-first</div>
            <div class="dashboard-div-second">block-small-second</div>
            <div class="dashboard-div-third">block-large</div>
        </div>
    </div>
</div>
<?php $render->component('dashboard_footer') ?>