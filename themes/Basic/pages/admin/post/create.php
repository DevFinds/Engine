<?php

/**
 * @var \Core\Render $render
 */


?>


<?php $render->component('header') ?>
<h1>Добавление новой записи</h1>
<div class="create_post-form-container container my-5">
    <form action="/admin/post/create" method="post" enctype="multipart/form-data">
        <label for="PostName" class="form-label">Название записи</label>
        <input type="text" name="PostName" id="PostName" class="form-control" aria-describedby="passwordHelpBlock">
        <div id="passwordHelpBlock" class="form-text">
            Ведите здесь название записи, которое будет отображаться на странице блога
        </div>
        <div class="mb-3">
            <label for="PostThumb" class="form-label">Обложка записи</label>
            <input class="form-control" name="PostThumb" type="file" id="PostThumb">
        </div>
        <div class="mb-3">
            <label for="PostContent" class="form-label">Текст записи</label>
            <textarea class="form-control" id="PostContent" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Опубликовать</button>

    </form>
</div>

<?php $render->component('footer') ?>