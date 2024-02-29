<?php

/**
 * @var \Core\Render $render
 * @var \Source\Models\User $user
 * @var \Source\Models\Role $role
 */
$user = $this->auth->getUser();
?>

<?php $render->component('dashboard_header'); ?>

<div class="account-page-container">
    <div class="account-cart">
        <img class="account-avatar" src="/assets/themes/Basic/img/avatar.png" alt="">
        <div class="account-cart-info">
            <div class ="account-cart-top-section">
                <span class="account-username"><?php echo $user->username() ?> <?php echo $user->lastname(); ?>
                    <img class="account-edit" src="/assets/themes/Basic/img/edit.svg" alt="">
                    <img class="account-logout" src="/assets/themes/Basic/img/logout.svg" alt="">
                </span>
            <span class="account-role"><?php echo $user->role() ?></span>
            </div>
            <hr class="account-hr">
            <span class="account-info"><?php echo $user->login() ?> <?php echo $user->email(); ?> <?php echo $user->phone_number(); ?></span>
        </div>
    </div>
    <div class="account-search-posts">

    </div>

</div>