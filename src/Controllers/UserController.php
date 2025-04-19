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
            $db->update('User', ['avatar' => $avatar_path], ['id' => $this->session()->get('id')]);
        }
        $this->redirect('/admin/user/account');
    }

    public function addNewUser()
    {
        $labels = [
            'email' => 'Email',
            'login' => 'Login',
            'password' => 'Password',
            'name' => 'Name',
            'lastname' => 'Lastname',
        ];

        $validation = $this->request()->validate([
            'email' => ['required', 'email', 'already_exist'],
            'login' => ['required', 'min:3', 'max:25', 'already_exist'],
            'password' => ['required', 'min:6', 'max:255'],
            'name' => ['required'],
            'lastname' => ['required']
        ], $labels);
        if (!$validation) {


            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/admin/dashboard/users');
            echo "<script>switchTab('users-create-user-form');</script>";
            dd('Validation failed', $this->request()->errors());
        }

        $userID = $this->getDatabase()->insert('User', [
            'username' => $this->request()->input('name'),
            'lastname' => $this->request()->input('lastname'),
            'login' => $this->request()->input('login'),
            'email' => $this->request()->input('email'),
            'password' => password_hash($this->request()->input('password'), PASSWORD_DEFAULT),
            'role' => $this->request()->input('role')
        ]);
        // dd($userID);
        $this->redirect('/admin/dashboard/users');
    }
}
