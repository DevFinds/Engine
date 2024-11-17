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
                        <div class="register-label_and_error">
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
                                            <span class="register-error-message"><?php echo $error; ?></span>
                                <?php  }
                                    }
                                } ?>

                        </div>
                        <input class="" type="text" id="login" name="login">
                        <div class="register-label_and_error">
                            <label for="email">Email</label>
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
                                            <span class="register-error-message"><?php echo $error; ?></span>
                                <?php  }
                                    }
                                } ?>

                        </div>
                        <input class="" type="email" id="email" name="email">
                        <div class="register-label_and_error">
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
                                            <span class="register-error-message"><?php echo $error; ?></span>
                                <?php  }
                                    }
                                } ?>

                        </div>
                        <input class="" type="password" id="password" name="password">
                        <button type="button" class="register-button" id="nextBtn">Далее</button>
                    </div>
                    <div class="register-step-2">
                        <div class="register-label_and_error">
                            <label for="user_name">Имя</label>
                            <?php
                            $data_to_check = [
                                'user_name',
                            ];

                            foreach ($data_to_check as $data) {
                                if ($session->has($data)) {

                            ?>
                                    <ul class="error-list d-flex flex-column">
                                        <?php foreach ($session->getFlash($data, 'nothing') as $error) {
                                        ?>
                                            <span class="register-error-message"><?php echo $error; ?></span>
                                <?php  }
                                    }
                                } ?>

                        </div>
                        <input class="" type="text" id="user_name" name="user_name">
                        <div class="register-label_and_error">
                            <label for="user_lastname">Фамилия</label>
                            <?php
                            $data_to_check = [
                                'user_lastname',
                            ];

                            foreach ($data_to_check as $data) {
                                if ($session->has($data)) {

                            ?>
                                    <ul class="error-list d-flex flex-column">
                                        <?php foreach ($session->getFlash($data, 'nothing') as $error) {
                                        ?>
                                            <span class="register-error-message"><?php echo $error; ?></span>
                                <?php  }
                                    }
                                } ?>

                        </div>
                        <input class="" type="text" id="user_lastname" name="user_lastname">
                        <div class="register-label_and_error">
                            <label for="user_phone">Номер телефона</label>
                            <?php
                            $data_to_check = [
                                'user_phone',
                            ];

                            foreach ($data_to_check as $data) {
                                if ($session->has($data)) {

                            ?>
                                    <ul class="error-list d-flex flex-column">
                                        <?php foreach ($session->getFlash($data, 'nothing') as $error) {
                                        ?>
                                            <span class="register-error-message"><?php echo $error; ?></span>
                                <?php  }
                                    }
                                } ?>

                        </div>
                        <input class="" type="text" id="user_phone" name="user_phone">
                        <div class="register_double_btn_block">
                            <button type="button" class="register-button" id="backBtn"><img src="assets\img\arrow.svg" alt=""></button>
                            <button type="submit" class="register-button" id="submitBtn">Зарегистрироваться</button>
                        </div>
                    </div>
                    <div class="privacy-container">
                        <input type="checkbox" id="privacy-policy" class="privacy-checkbox" name="scales" />
                        <label for="privacy-policy" class="privacy-label">Я соглашаюсь с политикой конфиденциальности и даю согласие на обработку персональных данных</label>
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