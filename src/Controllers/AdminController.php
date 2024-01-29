<?php

namespace Source\Controllers;


use Core\Controller\Controller;

class AdminController extends Controller
{

    public function registerUser(): void
    {
        // Получаем имя данного контроллера
        //$controller_name = substr(get_class($this), -14, -10);
        $this->render('admin/users/register');
    }

    public function registerUser_to_db()
    {

        dd($_POST);
    }
}
