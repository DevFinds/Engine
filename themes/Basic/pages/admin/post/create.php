<?php

/**
 * @var \Core\Render $render
 */


?>


<?php $render->component('header') ?>
<h1>Добавление новой записи</h1>
<div class="posts-toolbar">
    <button onclick="execCmd('bold')">Bold</button>
    <button onclick="execCmd('italic')">Italic</button>
    <button onclick="execCmd('underline')">Underline</button>
    <button onclick="execCmd('insertOrderedList')">Ordered List</button>
    <button onclick="execCmd('insertUnorderedList')">Unordered List</button>
    <button onclick="execCmd('createLink', prompt('Enter URL:'))">Insert Link</button>
    <button onclick="execCmd('unlink')">Unlink</button>
    <button onclick="execCmd('justifyLeft')">Align Left</button>
    <button onclick="execCmd('justifyCenter')">Align Center</button>
    <button onclick="execCmd('justifyRight')">Align Right</button>
    <button onclick="execCmd('justifyFull')">Justify</button>
</div>
<div class="posts-editor" contenteditable="true" style="height: 250px; padding: 16px"></div>
<form method="POST" action="/admin/post/create" enctype="multipart/form-data">
    <input type="hidden" name="content" id="hiddenContent">
    <input type="file" name="PostThumb"> <!-- Поле для выбора файла -->
    <button type="submit" onclick="saveContent()">Сохранить</button>
</form>

<script>
    function execCmd(command, value = null) {
        document.execCommand(command, false, value);
    }

    function saveContent() {
        document.getElementById('hiddenContent').value = document.getElementById('editor').innerHTML;
    }
</script>

<?php $render->component('footer') ?>