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
        flex-direction: column;
        gap: 16px;
    }

    .error-message-container p {
        padding: 24px;
        background-color:rgb(46, 46, 46);
        border-radius: 6px;
        
    }
</style>
<div class="error-message-container">
    <h1>Ошибка, страница не найдена - 404</h1>
    <p><?php echo $data['error'] ?></p>
    <a href="/">Вернуться на главную</a>
</div>

<?php $render->component('footer') ?>