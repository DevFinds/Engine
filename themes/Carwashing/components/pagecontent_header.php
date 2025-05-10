<!-- Header страницы -->
<?php $user = $this->auth->getUser(); ?>
<div class="page-content-header">

    <!-- Хлебные крошки -->
    <div class="breadcrumbs-container">
        <a href="" class="breadcrumb-previous">Страницы</a>
        <span class="breadcrumb-separator">/</span>
        <a href="" class="breadcrumb-current">Главная</a>
    </div>

    <!-- Пользователь -->
    <div class="user-container">
        <img src="/storage/default/empty_avatar.png" class="user-avatar" alt="">
        <span class="username"><?php echo $user->username(); ?> <?php echo $user->lastname(); ?></span>
        <button id="user-menu-toggler" class="user-menu-toggler"><svg id="user-menu-icon" class="user-menu-icon" width="10" height="6" viewBox="0 0 10 6" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </div>

    <!-- Popup -->
    <div id="account-popup" class="account-popup hidden">
        <a href="/admin/user/account">
            <div class="account-popup-point">
                <span>Аккаунт</span>
            </div>
        </a>
        <a href="/logout">
            <div class="account-popup-point">
                <span>Выйти</span>
            </div>
        </a>
    </div>
    <script src="main.js"></script>
</div>