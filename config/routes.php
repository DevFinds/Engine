<?php

use Core\http\Router\Route;
use Source\Controllers\HomeController;
use Source\Controllers\AdminController;
use Source\Controllers\RegisterController;

return [

    Route::get('/home', [HomeController::class, 'index']),
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/admin/users/register', [AdminController::class, 'registerUser']),
    Route::post('/admin/users/register', [AdminController::class, 'registerUser_to_db']),
    Route::get('/register', [RegisterController::class, 'index']),
    Route::post('/register', [RegisterController::class, 'register']),

];
