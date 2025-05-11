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
        $validation = $this->request()->validate(
            [
                'email' => ['required', 'email', 'already_exist'],
                'login' => ['required', 'min:3', 'max:25', 'already_exist'],
                'password' => ['required', 'min:6'],
                'user_name' => ['required'],
                'user_lastname' => ['required'],
                'phone_number' => ['required'],
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

            dd('Validation failed', $this->request()->errors());
            $this->redirect('/register');
        }

        try {
            $userID = $this->getDatabase()->insert('users', [
                'username' => $this->request()->input('user_name'),
                'lastname' => $this->request()->input('user_lastname'),
                'login' => $this->request()->input('login'),
                'phone_number' => $this->request()->input('phone_number'),
                'email' => $this->request()->input('email'),
                'password' => password_hash($this->request()->input('password'), PASSWORD_DEFAULT),
                'role' => 1,
            ]);
            if ($userID) {
                $this->session()->set('success', 'Вы успешно зарегистрировались!');
                $this->redirect('/login');
            } else {
                $this->session()->set('error', 'Ошибка регистрации. Попробуйте еще раз.');
                $this->redirect('/register');
            }
        } catch (\Exception $e) {


            //$this->redirect('/register');
            //dd('Error', $e->getMessage());
        }
        //$this->redirect('/');
    }
}
