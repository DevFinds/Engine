<?php

namespace Source\Controllers;


use Core\Controller\Controller;
use Core\http\Redirect;

class AdminController extends Controller
{

    public function registerUser(): void
    {
        // Получаем имя данноconditionго контроллера
        //$controller_name = substr(get_class($this), -14, -10);
        $this->render('admin/users/register');
    }

    public function registerUser_to_db()
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

            $this->redirect('/admin/users/register');
            //dd('Validation failed', $this->request()->errors());
        }

        dd('Validation passed');
    }
}
