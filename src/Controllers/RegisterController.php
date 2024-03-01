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
            'user_email' => ['required', 'already_exists', 'email'],
            'user_login' => ['required', 'min:3', 'max:25', 'already_exists'],
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
            'login' => $this->request()->input('user_login'),
            'email' => $this->request()->input('user_email'),
            'password' => password_hash($this->request()->input('user_password'), PASSWORD_DEFAULT),
            'role' => '1',
        ]);

        $this->redirect('/');
    }
}
