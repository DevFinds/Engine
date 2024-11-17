<?php

/**
 * @var \Core\Render $render
 * @var ConfigInterface $config
 */

?>
<?php $render->component('dashboard_header');



?>
<div class="dashboard-bottom-section">
    <div class="dashboard-div-first">
        <div class="dashboard-settings-left-column">
            <ul class="dashboard-setting-left-list-">
                <li class="dashboard-settings-list-item-"><input type="text" class="dashboard-settings-input" value="<?php echo $config->getJson('app.name') ?>"><button class="dashboard-settings-save-changes-button"></button></li>
                <li class="dashboard-settings-list-item-"><input type="text" class="dashboard-settings-input" value="<?php echo $config->getJson('app.url') ?>"><button class="dashboard-settings-save-changes-button"></button></li>
                <li class="dashboard-settings-list-item-"><input type="text" class="dashboard-settings-input" value="<?php echo $config->getJson('app.theme') ?>"><button class="dashboard-settings-save-changes-button"></button></li>
                <li class="dashboard-settings-list-item-"><input type="text" class="dashboard-settings-input" value="<?php echo $config->getJson('app.avatar_max_file_size') ?>"><button class="dashboard-settings-save-changes-button"></button></li>
                <li class="dashboard-settings-list-item-"><input type="text" class="dashboard-settings-input"><button class="dashboard-settings-save-changes-button"></button></li>
            </ul>
        </div>
    </div>
    <div class="dashboard-div-second">
        <a href="/admin/dashboard/db/manage" class="manage-db-button">Управление БД</a>
        <a href="/admin/dashboard/settings/switch-theme" class="switch-theme-button">Выбрать тему</a>
        <a href="/admin/dashboard/settings/route-manager" class="route-manage-button">Редактор маршрутов</a>
    </div>

</div>
<?php $render->component('dashboard_footer'); ?>