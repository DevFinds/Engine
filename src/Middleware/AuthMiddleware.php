<?php

// Данный посредник проверяет наличие авторизации у пользователя
// В случае, если данный пользователь не авторизован, посредник 
// переадресует его на страницу авторизации

namespace Source\Middleware;

use Core\Middleware\AbstractMiddleware;

class AuthMiddleware extends AbstractMiddleware
{
    public function handle(): void
    {
        if (!$this->auth->check()) {
            $this->redirect->to('/login');
        }
    }
}
