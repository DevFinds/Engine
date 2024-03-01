<?php

namespace Source\Controllers;


use Core\http\Redirect;
use Core\Controller\Controller;
use Source\Services\RoleService;
use Source\Services\UserService;

class AdminController extends Controller
{

    public function UserList(): void
    {
        // Получаем имя данноconditionго контроллера
        //$controller_name = substr(get_class($this), -14, -10);
        $this->render('admin/users');
    }

    public function dashboardGeneral()
    {
        $this->render('admin/dashboard/general');
    }

    public function dashboardUsers()
    {
        $users = new UserService($this->getDatabase());
        $roles = new RoleService($this->getDatabase());
        $this->render('admin/dashboard/users', [
            'users' => $users->getAllFromDB(),
            'roles' => $roles->getAllFromDB()
        ]);
    }

    public function deleteuser()
    {
    }

    public function posts()
    {
        $this->render('admin/dashboard/posts');
    }
}
