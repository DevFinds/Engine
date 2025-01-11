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

        <?php $render->component('pagecontent_header'); ?>


        <!-- Содержимое страницы -->
        <div class="page-content-body">
            <h1 class="page-title">Аналитика по компании</h1>

            <div class="analitics-grid">
                <div class="analitics-grid-leftside">
                    <div class="small-widgets-container">
                        <div class="small-widget">
                            <div class="small-widget-header">
                                <span class="small-widget-title">Общая сумма продаж</span>
                                <a href="#" class="small-widget-button">Отчет</a>
                            </div>
                            <div class="analitics-tabs-container">
                                <div class="analitics-tabs">
                                    <div class="analitics-tab active" data-group="sales" data-tab="days" onclick="switchTab_group('sales', 'days')">День</div>
                                    <div class="analitics-tab" data-group="sales" data-tab="weeks" onclick="switchTab_group('sales', 'weeks')">Неделя</div>
                                    <div class="analitics-tab" data-group="sales" data-tab="mounths" onclick="switchTab_group('sales', 'mounths')">Месяц</div>
                                </div>
                            </div>
                            <div class="tab-content active" data-group="sales" id="daysContainer">
                                <div class="analitics-price-container">
                                    <h2>12 000₽</h2>
                                </div>
                            </div>
                            <div class="tab-content" data-group="sales" id="weeksContainer">
                                <div class="analitics-price-container">
                                    <h2>28 000₽</h2>
                                </div>
                            </div>
                            <div class="tab-content" data-group="sales" id="mounthsContainer">
                                <div class="analitics-price-container">
                                    <h2>64 000₽</h2>
                                </div>
                            </div>
                        </div>

                        <div class="small-widget">
                            <div class="small-widget-header">
                                <span class="small-widget-title">Кол-во выполненных услуг</span>
                                <a href="#" class="small-widget-button">Отчет</aclass=>
                            </div>
                            <div class="analitics-tabs-container">
                                <div class="analitics-tabs">
                                    <div class="analitics-tab active" data-group="services" data-tab="days" onclick="switchTab_group('services', 'days')">День</div>
                                    <div class="analitics-tab" data-group="services" data-tab="weeks" onclick="switchTab_group('services', 'weeks')">Неделя</div>
                                    <div class="analitics-tab" data-group="services" data-tab="mounths" onclick="switchTab_group('services', 'mounths')">Месяц</div>
                                </div>
                            </div>
                            <div class="tab-content active" data-group="services" id="daysContainer-services">
                                <div class="analitics-price-container">
                                    <h2>36 услуг</h2>
                                </div>
                            </div>
                            <div class="tab-content" data-group="services" id="weeksContainer-services">
                                <div class="analitics-price-container">
                                    <h2>121 услуга</h2>
                                </div>
                            </div>
                            <div class="tab-content" data-group="services" id="mounthsContainer-services">
                                <div class="analitics-price-container">
                                    <h2>457 услуг</h2>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="big-widgets-container">
                        <div class="big-widget">
                            <div class="big-widget-header">
                                <span class="big-widget-title">Критические остатки на складе</span>
                                <a href="#" class="big-widget-button">Подробнее</a>
                            </div>

                            <div class="analitics-tabs-container" data-group="warehouse">

                                <div class="analitics-tabs">
                                    <div class="analitics-tab active" data-group="warehouse" data-tab="OOO" onclick="switchTab_group('warehouse', 'OOO')">Склад ООО</div>
                                    <div class="analitics-tab" data-group="warehouse" data-tab="IP" onclick="switchTab_group('warehouse', 'IP')">Склад ИП</div>

                                </div>
                            </div>

                            <div class="tab-content active" id="OOOContainer" data-group="warehouse">

                                <div class="big-widget-list">
                                    <table>
                                        <tr>
                                            <td>Сникерс большой</td>
                                            <td>11 шт.</td>
                                        </tr>
                                        <tr>
                                            <td>Сникерс большой</td>
                                            <td>11 шт.</td>
                                        </tr>
                                        <tr>
                                            <td>Сникерс большой</td>
                                            <td>11 шт.</td>
                                        </tr>
                                        <tr>
                                            <td>Сникерс большой</td>
                                            <td>11 шт.</td>
                                        </tr>
                                        <tr>
                                            <td>Сникерс большой</td>
                                            <td>11 шт.</td>
                                        </tr>
                                        <tr>
                                            <td>Сникерс большой</td>
                                            <td>11 шт.</td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                            <div class="tab-content" id="IPContainer" data-group="warehouse">

                                <div class="big-widget-list">
                                    <table>
                                        <tr>
                                            <td>Сникерс маленький</td>
                                            <td>11 шт.</td>
                                        </tr>
                                        <tr>
                                            <td>Сникерс маленький</td>
                                            <td>11 шт.</td>
                                        </tr>
                                        <tr>
                                            <td>Сникерс маленький</td>
                                            <td>11 шт.</td>
                                        </tr>
                                        <tr>
                                            <td>Сникерс маленький</td>
                                            <td>11 шт.</td>
                                        </tr>
                                        <tr>
                                            <td>Сникерс маленький</td>
                                            <td>11 шт.</td>
                                        </tr>
                                        <tr>
                                            <td>Сникерс маленький</td>
                                            <td>11 шт.</td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="analitics-grid-rightside">
                    <p></p>
                </div>
            </div>


        </div>
    </div>
</div>

<?php $render->component('dashboard_footer'); ?>
<!-- <?php $render->component('modals/attention_popup'); ?> -->
<!-- <?php $render->component('modals/error_popup'); ?> -->