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
            <h1>Регистрация</h1>
            <ul class="icon-list">
                <li class="icon-item"><a href=""><img src="assets\img\logo_git.svg" alt=""></a></li>
                <li class="icon-item"><a href=""><img src="assets\img\logo_google.svg" alt=""></a></li>
                <li class="icon-item"><a href=""><img src="assets\img\logo_discord.svg" alt=""></a></li>
                <li class="icon-item"><a href=""><img src="assets\img\logo_telegram.svg" alt=""></a></li>
            </ul>
            <div class="right-container">
                <form action="/register" method="post">
                    <label for="user_login">Логин</label>
                    <input type="text" id="login" name="user_login">
                    <div class="error-container">

                        <?php
                        $data_to_check = [
                            'user_login',
                        ];

                        foreach ($data_to_check as $data) {
                            if ($session->has($data)) {

                        ?>
                                <ul class="error-list d-flex flex-column">
                                    <?php foreach ($session->getFlash($data, 'nothing') as $error) {
                                    ?>
                                        <li class="error-item danger my-1"><?php echo $error; ?></li>
                            <?php  }
                                }
                            } ?>

                                </ul>
                    </div>

                    <label for="user_email">Email</label>
                    <input type="email" id="email" name="user_email">
                    <div class="error-container">

                        <?php
                        $data_to_check = [
                            'user_email',
                        ];

                        foreach ($data_to_check as $data) {
                            if ($session->has($data)) {

                        ?>
                                <ul class="error-list d-flex flex-column">
                                    <?php foreach ($session->getFlash($data, 'nothing') as $error) {
                                    ?>
                                        <li class="error-item danger my-1"><?php echo $error; ?></li>
                            <?php  }
                                }
                            } ?>

                                </ul>
                    </div>

                    <label for="user_password">Пароль</label>
                    <input type="password" id="password" name="user_password">
                    <div class="error-container">

                        <?php
                        $data_to_check = [
                            'user_password'
                        ];

                        foreach ($data_to_check as $data) {
                            if ($session->has($data)) {

                        ?>
                                <ul class="error-list d-flex flex-column">
                                    <?php foreach ($session->getFlash($data, 'nothing') as $error) {
                                    ?>
                                        <li class="error-item danger my-1"><?php echo $error; ?></li>
                            <?php  }
                                }
                            } ?>

                                </ul>
                    </div>

                    <button type="submit" class="register-button">Зарегистрироваться</button>
                </form>


                <div class="auth-container">
                    <p class="auth-paragraph">Уже есть аккаунт?</p>
                    <a href="/login" class="auth-button">Войти</a>
                </div>
            </div>
        </div>

    </div>
</div>




<?php $render->component('footer') ?>