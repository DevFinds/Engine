<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 */

$user = $this->auth->getUser();
$role = $this->auth->getRole();
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
        <div class="user-card">
            <img src="/storage/default/empty_avatar.png" class="accountpage-avatar" alt="">
            <div class="user-card-info">
                <div class="user-card-head">
                    <div>
                        <h1><?php echo $user->username(); ?> <?php echo $user->lastname(); ?></h1>
                        <form action="">
                            <button type="submit" class="user-card-edit-button"><img src="/assets/themes/Carwashing/img/settings-icon.svg" alt=""></button>
                        </form>
                    </div>
                    <h2 style="margin-top: 8px;"><?php echo $role->name() ?></h2>
                </div>
                <div class="user-card-attributes">
                    <div class="user-card-item">
                        <img src="/assets/themes/Carwashing/img/user.svg" alt="">
                        <span><?php echo $user->login(); ?></span>
                    </div>
                    <div class="user-card-item">
                        <img src="/assets/themes/Carwashing/img/mail.svg" alt="">
                        <span><?php echo $user->email(); ?></span>
                    </div>
                    <div class="user-card-item">
                        <img src="/assets/themes/Carwashing/img/phone.svg" alt="">
                        <span><?php echo $user->phone_number(); ?></span>
                    </div>
                    <div style="visibility: hidden;" class="user-card-item">
                        <img src="/assets/themes/Carwashing/img/page.svg" alt="">
                        <span>ООО</span>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php $render->component('dashboard_footer'); ?>