<?php

use Core\http\Router\Route;
use Source\Controllers\HomeController;

return [

    Route::get('/home', [HomeController::class, 'index']),
    Route::get('/', [HomeController::class, 'index']),

];
