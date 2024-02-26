<?php

use Core\http\Router\Route;
use Source\Controllers\HomeController;
use Source\Controllers\AdminController;
use Source\Controllers\LoginController;
use Source\Controllers\PostController;
use Source\Controllers\RegisterController;
use Source\Middleware\AuthMiddleware;
use Source\Middleware\GuestMiddleware;

return [

    Route::get('/home', [HomeController::class, 'index']),
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/admin/users', [AdminController::class, 'UserList'], [AuthMiddleware::class]),
    Route::post('/admin/users/register', [AdminController::class, 'registerUser_to_db']),
    Route::get('/register', [RegisterController::class, 'index'], [GuestMiddleware::class]),
    Route::post('/register', [RegisterController::class, 'register']),
    Route::get('/login', [LoginController::class, 'index'], [GuestMiddleware::class]),
    Route::post('/login', [LoginController::class, 'login']),
    Route::post('/logout', [LoginController::class, 'logout']),
    Route::get('/admin/post/create', [PostController::class, 'post_creation'], [AuthMiddleware::class]),
    Route::post('/admin/post/create', [PostController::class, 'create_new_post'], [AuthMiddleware::class]),
    Route::get('/admin/dashboard/general', [AdminController::class, 'dashboardGeneral'], [AuthMiddleware::class]),
    Route::get('/admin/dashboard/users', [AdminController::class, 'dashboardUsers'], [AuthMiddleware::class]),
    Route::post('/admin/dashboard/deleleteuser', [AdminController::class, 'deleteuser'], [AuthMiddleware::class]),

];
