<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 */
?>

<!-- Сайдбар с меню -->
<div class="menu-sidebar">
    <a href="/"><img src="/assets/themes/Carwashing/img/brand-logo.svg" alt="" class="brand-logo"></a>

    <?php $render->enqueue_menu('sidebar_menu'); ?>

    <div class="developer-container">
        <a href="" class="developer-link">Soft by DevFinds</a>
        <span class="version">v.1.0</span>
    </div>
</div>