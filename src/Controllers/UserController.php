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

    public function changeAvatar()
    {
        $avatar_file = $this->request()->file('Avatar');
        $avatar_path = "/storage/" . $avatar_file->move('avatars');
        $db = $this->getDatabase();
    
        // Проверка, что есть данные для обновления
        if (!empty($avatar_path)) {
            $db->update('users', ['avatar' => $avatar_path], ['id' => $this->session()->get('user_id')]);
        }
        $this->redirect('/admin/user/account');
    }

}