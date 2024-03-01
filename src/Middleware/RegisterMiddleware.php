<?php


use Core\Middleware\AbstractMiddleware;

class RegisterMiddleware extends AbstractMiddleware
{
    public function handle(): void
    {
        if ($this->auth->session_field('user_email') == $this->auth->database) {
        }
    }
}
