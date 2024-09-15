<?php

// Введем свою переменную, которая будет возвращать путь до корневой папки
define('APP_PATH', dirname(__DIR__));
define('CONFIG_PATH', APP_PATH . '/config');
define('PLUGINS_FOLDER_PATH', APP_PATH . 'src/plugins');
require_once APP_PATH . '/vendor/autoload.php';

use Core\App;

$app = new App();
$app->run();
