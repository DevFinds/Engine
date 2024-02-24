<?php

namespace Source\Controllers;


use Core\Controller\Controller;
use Core\http\Redirect;

class AdminController extends Controller
{

    public function UserList(): void
    {
        // Получаем имя данноconditionго контроллера
        //$controller_name = substr(get_class($this), -14, -10);
        $this->render('admin/users');
    }

    public function registerUser_to_db()
    {
        $this->redirect('/admin/users/register');
    }

    public function dashboardGeneral()
    {
        $this->render('admin/dashboard/general');
    }

    public function dashboardUsers()
    {
        $this->render('admin/dashboard/users');
    }
}
