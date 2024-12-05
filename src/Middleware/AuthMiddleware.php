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

        dd($this->request);
        if ($this->auth->getRole()->perm_level() < 2) {
            $this->redirect->to('/login');
        }
    }
}
