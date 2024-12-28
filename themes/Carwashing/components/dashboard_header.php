<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 */

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php $render->enqueue_selected_styles([ 'select2.min.css', 'modals.css', 'flatpickr.min.css', 'main.css']); ?>
    <title>Админка</title>
</head>
<style>
    * {
        color: #FFF !important
    }
</style>

<body>

    <div class="app-container">