<?php

namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\RoleService;
use Source\Services\UserService;

class UserController extends Controller
{
    public function account()
    {
        $users = new UserService($this->getDatabase());
        $roles = new RoleService($this->getDatabase());
        $this->render('admin/user/account', [
            'users' => $users->getAllFromDB(),
            'roles' => $roles->getAllFromDB()
        ]);
    }
}