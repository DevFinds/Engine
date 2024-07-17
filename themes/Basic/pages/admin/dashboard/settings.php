<?php

/**
 * @var \Core\Render $render
 * @var ConfigInterface $config
 */


?>
<?php $render->component('dashboard_header'); ?>
<div class="dashboard-bottom-section">
    <div class="dashboard-settings-left-column">
        <ul class="dashboard-setting-left-list-">
            <li class="dashboard-settings-list-item-"><input type="text" class="dashboard-settings-input" value="<?php echo $config->get('app.name') ?>"><button class="dashboard-settings-save-changes-button"></button></li>
            <li class="dashboard-settings-list-item-"><input type="text" class="dashboard-settings-input" value="<?php echo $config->get('app.url') ?>"><button class="dashboard-settings-save-changes-button"></button></li>
            <li class="dashboard-settings-list-item-"><input type="text" class="dashboard-settings-input" value="<?php echo $config->get('app.theme') ?>"><button class="dashboard-settings-save-changes-button"></button></li>
            <li class="dashboard-settings-list-item-"><input type="text" class="dashboard-settings-input" value="<?php echo $config->get('app.avatar_max_file_size') ?>"><button class="dashboard-settings-save-changes-button"></button></li>
            <li class="dashboard-settings-list-item-"><input type="text" class="dashboard-settings-input"><button class="dashboard-settings-save-changes-button"></button></li>
        </ul>
    </div>
</div>
<?php $render->component('dashboard_footer'); ?>