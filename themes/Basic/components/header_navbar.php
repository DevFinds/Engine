<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 */


$user = $this->auth->getUser();
?>

<header class="container-fluid">
    <nav class="navbar navbar-expand-lg bg-body-tertiary container container-fluid">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">ShapeSider</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/home">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Регистрация</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Авторизация</a>
                    </li>
                </ul>
                <?php if ($auth->check()) { ?>
                    <div class="d-flex align-baseline row">
                        <p class=" col"><?php echo $user->email() ?></p>
                        <form action="/logout" method="post">
                            <button type="submit" class="btn btn-warning col">Выйти</button>
                        </form>

                    </div>
                <?php }   ?>
            </div>
        </div>
    </nav>
</header>