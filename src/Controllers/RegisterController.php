<?php


namespace Source\Controllers;

use Core\Controller\Controller;

class RegisterController extends Controller
{
    public function index()
    {
        $this->render('register');
    }

    public function registerUser_to_db()
    {
        $this->redirect('/admin/users/register');
    }

    public function register()
    {
        $validation = $this->request()->validate([
            'email' => ['required', 'email', 'already_exist'],
            'login' => ['required', 'min:3', 'max:25', 'already_exist'],
            'password' => ['required', 'min:6', 'max:255'],
            'user_name' => ['required'],
            'user_lastname' => ['required'],
            'user_phone' => ['required'],
            'privacy-policy' => ['required'],
        ],
        [
            'email' => 'Электронная почта',
            'login' => 'Логин',
            'password' => 'Пароль',
            'user_name' => 'Имя',
            'user_lastname' => 'Фамилия',
            'phone_number' => 'Номер телефона',
            'privacy-policy' => 'Согласие с политикой конфиденциальности',
        ]
    );

        if (!$validation) {


            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/register');
            //dd('Validation failed', $this->request()->errors());
        }

        $userID = $this->getDatabase()->insert('users', [
            'username' => $this->request()->input('user_name'),
            'lastname' => $this->request()->input('user_lastname'),
            'login' => $this->request()->input('login'),
            'email' => $this->request()->input('email'),
            'password' => password_hash($this->request()->input('password'), PASSWORD_DEFAULT),
            'role' => '1',
        ]);
        if ($userID) {
            $this->session()->set('success', 'Регистрация успешна! Войдите в аккаунт.');
            $this->redirect('/login');
        } else {
            $this->session()->set('error', 'Ошибка при регистрации. Попробуйте снова.');
            $this->redirect('/register');
        }
        //$this->redirect('/');
    }
}
