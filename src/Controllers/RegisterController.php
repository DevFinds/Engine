<?php


namespace Source\Controllers;

use Core\Controller\Controller;

class RegisterController extends Controller
{
    public function index()
    {
        $this->render('register');
    }

    public function register()
    {
        $validation = $this->request()->validate([
            'user_name' => ['required', 'min:3', 'max:25'],
            'user_email' => ['required'],
            'user_login' => ['required', 'min:3', 'max:25'],
            'user_password' => ['required', 'min:6', 'max:255']
        ]);

        if (!$validation) {


            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/register');
            //dd('Validation failed', $this->request()->errors());
        }

        $userID = $this->getDatabase()->insert('users', [
            'username' => $this->request()->input('user_name'),
            'login' => $this->request()->input('user_login'),
            'email' => $this->request()->input('user_email'),
            'password' => password_hash($this->request()->input('user_password'), PASSWORD_DEFAULT),
        ]);

        dd("Пользователь создан с ID: $userID");
    }
}
