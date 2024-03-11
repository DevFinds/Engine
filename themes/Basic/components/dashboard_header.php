<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 */

$user = $this->auth->getUser();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php $render->enqueue_all_styles(); ?>
    <link rel="stylesheet" type="text/css" href="./assets/css/dashboard_style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&amp;display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Dashboard</title>
</head>

<body data-aos-easing="ease" data-aos-duration="400" data-aos-delay="0">
    <header></header>
    <main>
        <div class="dashboard-page-container">
            <div class="dashboard-navbar">
                <a href="/"><img src="/assets/themes/Basic/img/dashborad_logo.svg" alt="" class="dashboard-logo"></a>
                <ul class="dashboard-menu">
                    <li class="dashboard-menu-item"><img src="/assets/themes/Basic/img/general-icon.svg" alt="" class="dashboard-link-icon"><a href="/admin/dashboard/general" class="dashboard-menu-link">Основное</a></li>
                    <li class="dashboard-menu-item"><img src="/assets/themes/Basic/img/user-icon.svg" alt="" class="dashboard-link-icon"><a href="/admin/dashboard/users" class="dashboard-menu-link">Пользователи</a></li>
                    <li class="dashboard-menu-item"><img src="/assets/themes/Basic/img/post-icon.svg" alt="" class="dashboard-link-icon"><a href="/admin/dashboard/posts" class="dashboard-menu-link">Записи</a></li>
                    <li class="dashboard-menu-item"><img src="/assets/themes/Basic/img/request-icon.svg" alt="" class="dashboard-link-icon"><a href="/admin/dashboard/requests" class="dashboard-menu-link">Заявки</a></li>
                    <li class="dashboard-menu-item"><img src="/assets/themes/Basic/img/setting-icon.svg" alt="" class="dashboard-link-icon"><a href="/admin/dashboard/settings" class="dashboard-menu-link">Настройки</a></li>
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
                            <img src="/assets/themes/Basic/img/loupe.svg" alt="">
                            <input type="text" placeholder="Поиск" class="dashboard-search-input">
                        </div>
                        <div class="dashboard-user-info">
                            <div class="dashboard-user-button">
                                <img class="dashboard-header-avatar" src="<?php echo $user->avatar()?>" alt="">
                                <span class="dashboard-username"><?php echo $user->username() ?> <?php echo $user->lastname(); ?>
                                    <img id="dashboard-collapse-button" class="dashboard-collapse-button" src="/assets/themes/Basic/img/collapse.svg" alt="">
                                </span>
                            </div>

                            <div class="dashboard-collapse-menu aos-init aos-animate" id="dashboard-collapse-menu" data-aos="flip-down">
                                <ul>
                                    <li>
                                        <a href="\admin\user\account">Аккаунт</a></li>
                                    <li>
                                        <form action="/logout" method="post"> <button>Выйти</button></form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>