<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 */

?>


<?php $render->component('header_without_navbar') ?>


<div class="body-container">
    <div class="form-container">
        <div class="left-side">
            <img src="./assets/img/logo_ShapeSider.svg" href="/" alt="logo">
            <p class="first-paragraph">Soft by DevFinds</p>
        </div>

        <div class="right-side">
            <h1>Авторизация</h1>
            <ul class="icon-list">
                <li class="icon-item"><a href=""><img src="assets\img\logo_git.svg" alt=""></a></li>
                <li class="icon-item"><a href=""><img src="assets\img\logo_google.svg" alt=""></a></li>
                <li class="icon-item"><a href=""><img src="assets\img\logo_discord.svg" alt=""></a></li>
                <li class="icon-item"><a href=""><img src="assets\img\logo_telegram.svg" alt=""></a></li>
            </ul>
            <div class="right-container">
                <form action="/login" method="post">
                    <div class="login-label_and_error">
                        <label for="login">Логин</label>
                    </div>
                    <input class="" type="text" id="login" name="user_login">
                    <div class="login-label_and_error">
                        <label for="password">Пароль</label>
                    </div>
                    <input class="" type="password" id="password" name="user_password">
                    <div class="register_double_btn_block">
                        <button type="submit" class="register-button" id="submitBtn">Войти</button>
                    </div>
                    <div class="auth-container">
                        <p class="auth-paragraph">Нет аккаунта?</p>
                        <a href="/register" class="auth-button">Регистрация</a>
                    </div>
                    <div class="error-container">

                        <?php
                        $data_to_check = [
                            'user_login',
                            'user_password'
                        ];

                        foreach ($data_to_check as $data) {
                            if ($session->has($data)) {

                        ?>
                                <ul class="error-list d-flex flex-column">
                                    <?php foreach ($session->getFlash($data, 'nothing') as $error) {
                                    ?>
                                        <li class="error-item btn btn-outline-danger my-1"><?php echo $error; ?></li>
                            <?php  }
                                }
                            } ?>

                                </ul>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php $render->component('footer') ?>