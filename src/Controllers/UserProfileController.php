<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Source\Services\RoleService;
use Source\Services\UserService;

class UserProfileController extends Controller
{
    public function index($id)
    {

        $profile_user = (new UserService($this->getDatabase()))->getAllFromDB()[$id - 1];
        $profile_user_role_name = (new RoleService($this->getDatabase()))->getAllFromDB()[$profile_user->role() - 1]->role_name();
        $this->render('admin/user/profile', ['profile_user' => $profile_user, 'profile_user_role_name' => $profile_user_role_name]);
    }
}
