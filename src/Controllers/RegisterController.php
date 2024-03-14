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
            'login' => ['required', 'min:3', 'max:25','already_exist'],
            'password' => ['required', 'min:6', 'max:255']
        ]);
        
        if (!$validation) {


            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/register');
            //dd('Validation failed', $this->request()->errors());
        }

        $userID = $this->getDatabase()->insert('users', [
            'login' => $this->request()->input('login'),
            'email' => $this->request()->input('email'),
            'password' => password_hash($this->request()->input('password'), PASSWORD_DEFAULT),
            'role' => '1',
        ]);

        //$this->redirect('/');
    }
}
