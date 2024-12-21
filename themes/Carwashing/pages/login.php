<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 */

?>


<?php $render->component('header_without_navbar') ?>

<style>
    h1 {
        color: #FFF !important;
        font-size: 40px;
        text-align: center;
        margin-bottom: 24px;
    }

    .body-container {
         display: flex;
         justify-content: center;
         align-items: center;
         justify-self: center;
         width: 100%;
         height: 100vh;
    }

    .right-container form{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        justify-self: center;
    }

    form input {
        min-width: 300px;
        max-width: 300px;
        height: 40px;
        border-radius: 10px;
        border: none;
        margin: 10px;
        padding: 12px 12px;
    }

    .auth-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        justify-self: center;
        margin-top: 20px;
        gap:48px;
    }

    .register-button {
        background-color: #707FDD;
        padding: 12px 32px;
        border: none;
        border-radius: 8px;
        min-width: 100%;
        margin-top: 20px;        
    }

    .register_double_btn_block {
        width: 300px;
        max-width: 300px;
    }
</style>

<div class="body-container">
    <div class="form-container">

        <div class="right-side">
            <h1>Авторизация</h1>
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