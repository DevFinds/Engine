<?php

/**
 * @var \Core\Render $render
 */


?>


<?php $render->component('header_without_navbar') ?>;
<style>
    .error-message-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
</style>
<div class="error-message-container">
<h1>Ошибка, страница не найдена - 404</h1>
</div>

<?php $render->component('footer') ?>