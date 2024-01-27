<?php

// Введем свою переменную, которая будет возвращать путь до корневой папки
define('APP_PATH', dirname(__DIR__));
require_once APP_PATH . '/vendor/autoload.php';

use Core\App;

$app = new App();
$app->run();
