<?php

/**
 * @var \Core\Render $render
 * @var ConfigInterface $config
 */

$user = $this->auth->getUser();
?>
<?php $render->component('dashboard_header'); ?>
<?php $render->component('menu_sidebar'); ?>
<!-- Тело страницы -->
<!-- Контейнер с содержимым страницы -->
<div class="page-content-container">
    <!-- Содержимое страницы -->
    <div class="page-content">

    <?php $render->component('pagecontent_header'); ?>


        <!-- Содержимое страницы -->
        <div class="settings-content-body">
            <div class="settings-inputs">
                <li>
                    <label class="settings-inputs-label">Название сайта</label>
                    <input type="text" placeholder="Ввести название сайта" value="<?php echo $config->getJson('app.name') ?>">
                </li>
                <li>
                    <label class="settings-inputs-label">URL</label>
                    <input type="text" placeholder="Ввести URL" value="<?php echo $config->getJson('app.url') ?>">
                </li>
            </div>
            <a href="/admin/dashboard/db/manage" class="database-button">
                <img src="/assets/themes/Carwashing/img/database_icon.svg" alt="">
                <div>Управление <span>DataBase</span></div>
            </a>
            <a href="/admin/dashboard/settings/route-manager" class="database-button">Управление маршрутами</a>
            <div class="themes-container">
                <p>Выберите тему</p>
                <div class="themes-section">
                    <?php $themes = $data['themes'] ?>
                    <?php foreach ($themes as $theme): ?>
                        <?php echo '
                            <form action="/admin/dashboard/settings/switch-theme/' . $theme . '" method="post" class="theme-container">
                            <button type="submit">
                            <div class="theme">
                                <div class="theme-header">
                                    <span>' . $theme . '</span>
                                    <a class="theme-settings-button">
                                        <img src="/assets/themes/Carwashing/img/settings-icon.svg" alt="">
                                    </a>
                                </div>
                                <p class="theme-description">Строгая и современная тема для прогрессивных людей и квадроберов</p>
                                <div class="theme-colors">
                                    <div class="theme-color theme-color-1"></div>
                                    <div class="theme-color theme-color-2"></div>
                                    <div class="theme-color theme-color-3"></div>
                                    <div class="theme-color theme-color-4"></div>
                                    <div class="theme-color theme-color-5"></div>
                                </div>
                            </div>
                            </button>
                            </form>
                            '; ?>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $render->component('dashboard_footer'); ?>