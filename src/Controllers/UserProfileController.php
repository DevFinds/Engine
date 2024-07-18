<?php


namespace Source\Controllers;

use Core\Controller\Controller;

class UserProfileController extends Controller
{
    public function index($id)
    {
        dd($this->getDatabase()->table('users')->find($id));
    }
}
