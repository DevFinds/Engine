<?php
/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 */
?>

<style>
    :root {
        --dark-middle-bg: #292F3A;
        --dark-bg: #272B35;
        --dark-hover: #353B4A;
        --dark-inactive: #8F97B2;
        --purple-accent: #707FDD;
        --white: #FFFFFF;
        --error-red: #F05B5B;
        --font-family: 'Inter', sans-serif;
    }

    h1 {
        color: var(--white) !important;
        font-size: 40px;
        text-align: center;
        margin-bottom: 24px;
        font-family: var(--font-family);
    }

    .body-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100vh;
        background-color: var(--dark-middle-bg);
    }

    .form-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .right-side {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 40px;
        background-color: var(--dark-bg);
        border-radius: 12px;
    }

    .right-container form {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .register-label_and_error {
        width: 300px;
        max-width: 300px;
        margin-bottom: 5px;
    }

    .register-label_and_error label {
        color: var(--white);
        font-family: var(--font-family);
        font-size: 14px;
    }

    form input {
        min-width: 300px;
        max-width: 300px;
        height: 40px;
        border-radius: 10px;
        border: none;
        margin: 10px 0;
        padding: 12px;
        background-color: var(--dark-hover);
        color: var(--white);
        font-family: var(--font-family);
        font-size: 14px;
    }

    form input:focus {
        outline: 2px solid var(--purple-accent);
    }

    .error-container {
        width: 300px;
        max-width: 300px;
        margin-top: 10px;
    }

    .error-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .error-item {
        color: var(--error-red);
        font-size: 12px;
        padding: 5px 10px;
        border: 1px solid var(--error-red);
        border-radius: 4px;
        margin-bottom: 5px;
        text-align: center;
    }

    .register-button {
        background-color: var(--purple-accent);
        padding: 12px 32px;
        border: none;
        border-radius: 8px;
        min-width: 100%;
        margin-top: 20px;
        color: var(--white);
        font-family: var(--font-family);
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .register-button:hover {
        background-color: #5a67d8;
    }

    .register_double_btn_block {
        width: 300px;
        max-width: 300px;
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .register_double_btn_block .register-button {
        flex: 1;
    }

    .auth-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 300px;
        max-width: 300px;
        margin-top: 20px;
        gap: 48px;
    }

    .auth-paragraph {
        color: var(--white);
        font-family: var(--font-family);
        font-size: 14px;
    }

    .auth-button {
        color: var(--purple-accent);
        font-family: var(--font-family);
        font-size: 14px;
        text-decoration: none;
    }

    .auth-button:hover {
        text-decoration: underline;
    }

    .privacy-container {
        width: 300px;
        max-width: 300px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
    }

    .privacy-checkbox {
        width: auto;
    }

    .privacy-label {
        color: var(--white);
        font-family: var(--font-family);
        font-size: 12px;
    }

    .hidden {
        display: none;
    }
</style>

<?php $render->component('header_without_navbar') ?>

<div class="body-container">
    <div class="form-container">
        <div class="right-side">
            <h1>Регистрация</h1>
            <div class="right-container">
                <form action="/register" method="post">
                    <div class="register-step-1">
                        <div class="register-label_and_error">
                            <label for="login">Логин</label>
                        </div>
                        <input type="text" id="login" name="login" autocomplete="username">
                        <div class="error-container">
                            <?php if ($session->has('login')): ?>
                                <ul class="error-list">
                                    <?php foreach ($session->getFlash('login') as $error): ?>
                                        <li class="error-item"><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="register-label_and_error">
                            <label for="email">Email</label>
                        </div>
                        <input type="email" id="email" name="email" autocomplete="email">
                        <div class="error-container">
                            <?php if ($session->has('email')): ?>
                                <ul class="error-list">
                                    <?php foreach ($session->getFlash('email') as $error): ?>
                                        <li class="error-item"><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="register-label_and_error">
                            <label for="password">Пароль</label>
                        </div>
                        <input type="password" id="password" name="password" autocomplete="current-password">
                        <div class="error-container">
                            <?php if ($session->has('password')): ?>
                                <ul class="error-list">
                                    <?php foreach ($session->getFlash('password') as $error): ?>
                                        <li class="error-item"><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="register_double_btn_block">
                            <button type="button" class="register-button" id="nextBtn">Далее</button>
                        </div>
                    </div>
                    <div class="register-step-2 hidden">
                        <div class="register-label_and_error">
                            <label for="user_name">Имя</label>
                        </div>
                        <input type="text" id="user_name" name="user_name" autocomplete="given-name">
                        <div class="error-container">
                            <?php if ($session->has('user_name')): ?>
                                <ul class="error-list">
                                    <?php foreach ($session->getFlash('user_name') as $error): ?>
                                        <li class="error-item"><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="register-label_and_error">
                            <label for="user_lastname">Фамилия</label>
                        </div>
                        <input type="text" id="user_lastname" name="user_lastname" autocomplete="family-name">
                        <div class="error-container">
                            <?php if ($session->has('user_lastname')): ?>
                                <ul class="error-list">
                                    <?php foreach ($session->getFlash('user_lastname') as $error): ?>
                                        <li class="error-item"><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="register-label_and_error">
                            <label for="phone_number">Номер телефона</label>
                        </div>
                        <input type="text" id="phone_number" name="phone_number" placeholder="+79991234567" autocomplete="tel">
                        <div class="error-container">
                            <?php if ($session->has('phone_number')): ?>
                                <ul class="error-list">
                                    <?php foreach ($session->getFlash('phone_number') as $error): ?>
                                        <li class="error-item"><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="privacy-container">
                            <input type="checkbox" id="privacy-policy" name="privacy-policy" class="privacy-checkbox">
                            <label for="privacy-policy" class="privacy-label">Я соглашаюсь с политикой конфиденциальности и даю согласие на обработку персональных данных</label>
                        </div>
                        <div class="error-container">
                            <?php if ($session->has('privacy-policy')): ?>
                                <ul class="error-list">
                                    <?php foreach ($session->getFlash('privacy-policy') as $error): ?>
                                        <li class="error-item"><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="register_double_btn_block">
                            <button type="button" class="register-button" id="backBtn">Назад</button>
                            <button type="submit" class="register-button" id="submitBtn">Зарегистрироваться</button>
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const step1 = document.querySelector('.register-step-1');
    const step2 = document.querySelector('.register-step-2');
    const nextBtn = document.getElementById('nextBtn');
    const backBtn = document.getElementById('backBtn');

    nextBtn.addEventListener('click', () => {
        step1.classList.add('hidden');
        step2.classList.remove('hidden');
    });

    backBtn.addEventListener('click', () => {
        step2.classList.add('hidden');
        step1.classList.remove('hidden');
    });
});
</script>

