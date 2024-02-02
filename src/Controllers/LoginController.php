<?php


namespace Source\Controllers;

use Core\Controller\Controller;

class LoginController extends Controller
{
    public function index()
    {
        $this->render('login');
    }

    public function login()
    {
        $login = $this->request()->input('user_login');
        $password = $this->request()->input('user_password');
        $this->getAuth()->attempt($login, $password);
        $this->redirect('/');
    }

    public function logout()
    {
        $this->getAuth()->logout();
        $this->redirect('/');
    }
}
