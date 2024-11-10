<?php

/**
 * @var \Core\Render $render
 * @var \Source\Models\User $user
 * @var \Source\Models\Role $role
 */

$user = $data['profile_user'];
$profile_user_role_name = $data['profile_user_role_name'];
?>

<?php $render->component('dashboard_header'); ?>

<div class="account-page-container">
    <div class="account-card">
        <img class="account-avatar" src="<?php echo $user->avatar() ?>" alt="">
        <form action="/user/change-avatar" method="post" enctype="multipart/form-data">
            <input class="form-control" name="Avatar" type="file" id="UserAvatar">
            <button type="submit">Изменить аватар</button>
        </form>
        <div class="account-card-info">
            <div class="account-card-top-section">
                <span class="account-username"><?php echo $user->username() ?> <?php echo $user->lastname(); ?></span>
            </div>
            <span class="account-role"><?php echo $profile_user_role_name ?></span>
            <hr class="account-hr">
            <div class="account-info">
                <ul class="account-info-list">
                    <li><img src="/assets/themes/Basic/img/person.svg" alt=""> <?php echo $user->login() ?></li>
                    <li><img src="/assets/themes/Basic/img/email.svg" alt=""><?php echo $user->email() ?></li>
                    <li><img src="/assets/themes/Basic/img/phone.svg" alt=""><?php echo $user->phone_number() ?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="account-search-posts">

    </div>

</div>



<?php $render->component('dashboard_footer'); ?>