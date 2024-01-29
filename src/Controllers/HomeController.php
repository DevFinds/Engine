<?php

namespace Source\Controllers;


use Core\Controller\Controller;

class HomeController extends Controller
{

    public function index(): void
    {
        // Получаем имя данного контроллера
        //$controller_name = substr(get_class($this), -14, -10);
        $this->render('home');
    }
}
