<?php

/**
 * @var \Core\Render $render
 */


?>


<?php $render->component('header');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Стили -->
    <link rel="stylesheet" href="assets/css/DF_OLD_custom.css">
    <link rel="stylesheet" href="assets/css/DF_OLD_reboot.css">
    <link rel="stylesheet" href="assets/fonts/Inter/">
    <title>Веб-студия DevFinds</title>

</head>

<body>
    <header>
    <div class="df-container"></div>
        <nav class="navigation">
            <ul class="navigation-list">
                <li class="navigation-item"><a href="#" class="navigation-link">услуги</a></li>
                <li class="navigation-item"><a href="/login" class="navigation-link">войти</a></li>
                <li class="navigation-item"><a href="/admin/dashboard/general" class="navigation-link">админка</a></li>
            </ul>
        </nav>
    </div>
    </header>



    <main>
        <div class="wrapper">
            <div class="content">
                <canvas id="pretty-bg"></canvas>
        <section class="first-screen-section">
            <div class="df-container">
                <img id="first-creen-logo" src="assets/img/DevFinds logo.svg" alt="Логотип DevFinds">
                <a href="#" class="df-a-button" id="contact-with-us-button">Связатся с нами</a>
            </div>
        </section>

        <section class="services-section">
            <div class="df-container">
                <h2 class="hero" data-speed="1.3">Мы предлагаем</h2>
                <div class="service-cards-block hero" data-speed="1.2">
                    
                    <div class="service-card-1">
                    <div class="service-card-body">
                        <h4 class="service-card-heading">Дизайн</h4>
                        <p class="service-card-description">Создание фирменного стиля и айдентики вашей компании</p>
                        <ul class="service-card-specs-list">
                            <li class="service-card-spec">Разработка прототипа</li>
                            <li class="service-card-spec">Создание дизайна</li>
                            <li class="service-card-spec">Айдентика бренда</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <div class="service-card-footer-icon-block">
                            <img src="assets/img/figma-icon.svg" alt="Figma">
                        </div>
                        <div class="service-card-footer-button-block">
                            <a href="#"><img src="assets/img/arrow-down.svg" alt=""></a>
                        </div>
                    </div>
                    </div>
                    
                    <div class="service-card-2">
                        <div class="service-card-body">
                            <h4 class="service-card-heading">Вёрстка</h4>
                            <p class="service-card-description">Создание фирменного стиля и айдентики вашей компании</p>
                            <ul class="service-card-specs-list">
                                <li class="service-card-spec">Разработка прототипа</li>
                                <li class="service-card-spec">Создание дизайна</li>
                                <li class="service-card-spec">Айдентика бренда</li>
                            </ul>
                        </div>
                        <div class="service-card-footer">
                            <div class="service-card-footer-icon-block">
                                <img src="assets/img/figma-icon.svg" alt="Figma">
                                <img src="assets/img/wordpress-cion.svg" alt="WordPress">
                            </div>
                            <div class="service-card-footer-button-block">
                                <a href="#"><img src="assets/img/arrow-down.svg" alt=""></a>
                            </div>
                        </div>
                        </div>

                        <div class="service-card-3">
                            <div class="service-card-body">
                                <h4 class="service-card-heading">С нуля</h4>
                                <p class="service-card-description">Создание фирменного стиля и айдентики вашей компании</p>
                                <ul class="service-card-specs-list">
                                    <li class="service-card-spec">Разработка прототипа</li>
                                    <li class="service-card-spec">Создание дизайна</li>
                                    <li class="service-card-spec">Айдентика бренда</li>
                                </ul>
                            </div>
                            <div class="service-card-footer">
                                <div class="service-card-footer-icon-block">
                                    <img src="assets/img/figma-icon.svg" alt="Figma">
                                    <img src="assets/img/wordpress-cion.svg" alt="WordPress">
                                    <img src="assets/img/vs_code-icon.svg" alt="VS Code">
                                </div>
                                <div class="service-card-footer-button-block">
                                    <a href="#"><img src="assets/img/arrow-down.svg" alt=""></a>
                                </div>
                            </div>
                            </div>

                </div>
            </div>
        </section>
        <section class="our-cases-section">
            <div class="df-container">
                <h2 >Наши кейсы</h2>
                <div class="our-cases-block">
                    <div class="case-card"><img src="assets/img/belosetr_case.png" alt=""></div>
                    <div class="case-card"><img src="assets/img/modern_cloth_shop-case.png" alt=""></div>
                    <div class="case-card"><img src="assets/img/pen_and_tool-case.png" alt=""></div>
                    <div class="case-card"><img src="assets/img/tours_japan_case.png" alt=""></div>
                    <div class="case-card"><img src="assets/img/neodental-case.png" alt=""></div>
                    <div class="case-card"><img src="assets/img/old_site-case.png" alt=""></div>
                </div>
            </div>
        </section>
        <section class="contact-form-seciton">
        <div class="df-container">
            <div class="contact-form-block">
                <div class="contact-form-block-description">
                    <h2>Есть вопрос?</h2>
                    <h3>Свяжитесь с нами и мы расскажем вам о наших примуществах</h3>
                    <p>Оставьте свои контактные данные — и мы проведем для вас демонстрацию</p>
                </div>
                <div class="contact-form-block-form">
                    <form action="" id="landing-contact-form">
                        <input type="text" placeholder="Ваше имя">
                        <input id="cleave-phone" type="text" placeholder="Номер телефона">
                        <button>Заказать звонок</button>
                    </form>
                </div>
            </div>
        </div>
        </section>
    </div>
</div>
    </main>
    

<?php $render->component('footer') ?>