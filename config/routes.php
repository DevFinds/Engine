<?php

use Core\http\Router\Route;
use Source\Controllers\HomeController;
use Source\Controllers\AdminController;

return [

    Route::get('/home', [HomeController::class, 'index']),
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/admin/users/add', [AdminController::class, 'adduser']),

];
