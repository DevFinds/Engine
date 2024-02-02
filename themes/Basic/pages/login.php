<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 */

?>


<?php $render->component('header') ?>

<div class="form-container container p-3 flex-column d-flex center my-5">
    <h1>Авторизация</h1>
    <form action="/login" method="post" class="">
        <label for="user_password" class="m-1 form-label">Логин</label>
        <input type="text" name="user_login" placeholder="Ваш логин" class="form-control">
        <label for="user_password" class="m-1 form-label">Пароль</label>
        <input type="password" name="user_password" placeholder="Ваш пароль" class="form-control">

        <button href="" type="submit" class="btn btn-primary my-4">Регистрация</button>

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