<?php


namespace Source\Controllers;

use Core\Controller\Controller;

class UserProfileController extends Controller
{
    public function index($id)
    {
        $this->render('admin/user/profile');
    }
}
