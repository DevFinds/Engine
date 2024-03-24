<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 */

?>


<?php $render->component('header') ?>


<div class="body-container">
    <div class="form-container">
        <div class="left-side">
            <img src="./assets/img/logo_ShapeSider.svg" alt="logo">
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
                <form action="/register" method="post">
                    <div class="login-label_and_error">
                        <label for="login">Логин</label>
                        <?php
                        $data_to_check = [
                            'login',
                        ];

                        foreach ($data_to_check as $data) {
                            if ($session->has($data)) {

                        ?>
                                <ul class="error-list d-flex flex-column">
                                    <?php foreach ($session->getFlash($data, 'nothing') as $error) {
                                    ?>
                                        <span class="login-error-message"><?php echo $error; ?></span>
                            <?php  }
                                }
                            } ?>

                    </div>
                    <input class="" type="text" id="login" name="login">
                    <div class="login-label_and_error">
                        <label for="password">Пароль</label>
                        <?php
                        $data_to_check = [
                            'password',
                        ];

                        foreach ($data_to_check as $data) {
                            if ($session->has($data)) {

                        ?>
                                <ul class="error-list d-flex flex-column">
                                    <?php foreach ($session->getFlash($data, 'nothing') as $error) {
                                    ?>
                                        <span class="login-error-message"><?php echo $error; ?></span>
                            <?php  }
                                }
                            } ?>

                    </div>
                    <input class="" type="password" id="password" name="password">
                    <div class="register_double_btn_block">
                        <button type="submit" class="register-button" id="submitBtn">Войти</button>
                    </div>
                    <div class="auth-container">
                        <p class="auth-paragraph">Уже есть аккаунт?</p>
                        <a href="/login" class="auth-button">Войти</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>



<div class="login-form-container container p-3 flex-column d-flex text-center my-5">
    <h1>Авторизация</h1>
    <form action="/login" method="post" class="">
        <label for="user_password" class="m-1 form-label">Логин</label>
        <input type="text" name="user_login" placeholder="Ваш логин" class="form-control">
        <label for="user_password" class="m-1 form-label">Пароль</label>
        <input type="password" name="user_password" placeholder="Ваш пароль" class="form-control">

        <button href="" type="submit" class="btn btn-primary my-4">Войти</button>

    </form>
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
</div>


<?php $render->component('footer') ?>