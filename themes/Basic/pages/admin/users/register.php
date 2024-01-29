<?php

/**
 * @var \Core\Render $render
 */


?>


<?php $render->component('header') ?>

<div class="form-container container w-50 center my-5">
    <h1>Регистрация</h1>
    <form action="/admin/users/register" method="post" class="">
        <label for="user_name" class="m-1 form-label">Ваше имя</label>
        <input type="text" name="user_name" placeholder="Ваше имя" class="form-control m-1">
        <label for="user_email" class="m-1 form-label">Ваш Email</label>
        <input type="email" name="user_email" placeholder="Ваш Email" class="form-control">
        <label for="user_login" class="m-1 form-label">Ваш логин</label>
        <input type="text" name="user_login" placeholder="Ваш логин" class="form-control">
        <label for="user_password" class="m-1 form-label">Ваш пароль</label>
        <input type="password" name="user_password" placeholder="Ваш пароль" class="form-control">

        <button href="" type="submit" class="btn btn-primary my-4">Регистрация</button>

    </form>
</div>


<?php $render->component('footer') ?>