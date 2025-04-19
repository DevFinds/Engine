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
        $labels = [
            'email' => 'Email',
            'login' => 'Login',
            'password' => 'Password',
            'user_name' => 'Name',
            'user_lastname' => 'Lastname',
            'user_phone' => 'Phone',
        ];

        $validation = $this->request()->validate([
            'email' => ['required', 'email', 'already_exist'],
            'login' => ['required', 'min:3', 'max:25', 'already_exist'],
            'password' => ['required', 'min:6', 'max:255'],
            'user_name' => ['required'],
            'user_lastname' => ['required'],
            'user_phone' => ['required'],
        ], $labels);

        if (!$validation) {


            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            //$this->redirect('/register');
            dd('Validation failed', $this->request()->errors());
        }

        try {

        $userID = $this->getDatabase()->insert('User', [
            'username' => $this->request()->input('user_name'),
            'lastname' => $this->request()->input('user_lastname'),
            'login' => $this->request()->input('login'),
            'email' => $this->request()->input('email'),
            'password' => password_hash($this->request()->input('password'), PASSWORD_DEFAULT),
            'role_id' => '1',
        ]);

        }

        catch (\Exception $e) {
            dd($e->getMessage());
        }

        //$this->redirect('/');
    }
}
