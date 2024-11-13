<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 */

$user = $this->auth->getUser();
?>

<?php $render->component('dashboard_header'); ?>
<!-- Сайдбар с меню -->
    <?php $render->component('menu_sidebar'); ?>
    <!-- Тело страницы -->
    <!-- Контейнер с содержимым страницы -->
    <div class="page-content-container">
        <!-- Содержимое страницы -->
        <div class="page-content">

            <!-- Header страницы -->
            <div class="page-content-header">

                <!-- Хлебные крошки -->
                <div class="breadcrumbs-container">
                    <a href="" class="breadcrumb-previous">Страницы</a>
                    <span class="breadcrumb-separator">/</span>
                    <a href="" class="breadcrumb-current">Главная</a>
                </div>

                <!-- Пользователь -->
                <div class="user-container">
                    <img src="<?php echo $user->avatar() ?>" class="user-avatar" alt="">
                    <span class="username"><?php echo $user->username(); ?> <?php echo $user->lastname(); ?></span>
                    <svg class="user-menu-icon" width="10" height="6" viewBox="0 0 10 6" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                </div>
            </div>


            <!-- Содержимое страницы -->
            <div class="page-content-body">
                <h1 class="page-title">Аналитика по компании</h1>


                <!-- Контейнер с 4 маленькими виджетами -->
                <div class="small-widgets-container">

                    <div class="small-widget small-widget-1">
                        <div class="small-widget-title">Всего сделок</div>
                        <div class="small-widget-value">20</div>
                    </div>

                    <div class="small-widget small-widget-2">
                        <div class="small-widget-title">Всего клиентов</div>
                        <div class="small-widget-value">20</div>
                    </div>

                    <div class="small-widget small-widget-3">
                        <div class="small-widget-title">Всего средств</div>
                        <div class="small-widget-value">20</div>
                    </div>

                    <div class="small-widget small-widget-4">
                        <div class="small-widget-title">Всего сделок</div>
                        <div class="small-widget-value">20</div>
                    </div>

                </div>


                <!-- Контейнер с 3 средними виджетами -->

                <div class="medium-widgets-container">
                    <div class="medium-widget medium-widget-1">
                        <div class="medium-widget-title">Всего сделок</div>
                        <div class="medium-widget-value">20</div>
                    </div>

                    <div class="medium-widget medium-widget-2">
                        <div class="medium-widget-title">Всего клиентов</div>
                        <div class="medium-widget-value">20</div>
                    </div>

                    <div class="medium-widget medium-widget-3">
                        <div class="medium-widget-title">Всего средств</div>
                        <div class="medium-widget-value">20</div>
                    </div>
                </div>


                <!-- Контейнер с большим виджетом -->

                <div class="big-widget-container">
                    <div class="big-widget">
                        <div class="big-widget-title">Всего сделок</div>
                        <div class="big-widget-value">20</div>
                    </div>
                </div>

            </div>
        </div>
    </div>