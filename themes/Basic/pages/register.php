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
                    <div class="register-step-1">
                        <label for="login">Логин</label>
                        <input type="text" id="login" name="login">
                        <div class="error-container">

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
                                            <li class="error-item danger my-1"><?php echo $error; ?></li>
                                <?php  }
                                    }
                                } ?>

                                    </ul>
                        </div>

                        <label for="email">Email</label>
                        <input type="email" id="email" name="email">
                        <div class="error-container">

                            <?php
                            $data_to_check = [
                                'email',
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

                        <label for="password">Пароль</label>
                        <input type="password" id="password" name="password">
                        <div class="error-container">

                            <?php
                            $data_to_check = [
                                'email',
                                'login',
                                'password'
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
                        <button type="button" class="register-button nextBtn" id="nextBtn">Далее</button>
                    </div>
                    <div class="register-step-2">

                        <label for="user_name">Имя</label>
                        <input type="text" id="user_name" name="user_name">
                        <label for="user_lastname">Фамилия</label>
                        <input type="text" id="user_lastname" name="user_lastname">
                        <label for="user_phone">Номер телефона</label>
                        <input type="text" id="user_phone" name="user_phone">
                        <div class="register_double_btn_block">
                            <button class="register-button backBtn" id="backBtn">Назад</button>
                            <button type="submit" class="register-button register_btn" id="submitBtn">Далее</button>
                        </div>
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




<?php $render->component('footer') ?>