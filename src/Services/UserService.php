<?php


namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\User;

class UserService
{
    public function __construct(
        private DatabaseInterface $db,
    ) {
    }

    /**
     * @return array<User>
     */

    public function getAllFromDB(): array
    {
        $users = $this->db->get('users');
        $users = array_map(function ($user) {
            return new User(
                $user['id'],
                $user['username'],
                $user['lastname'],
                $user['login'],
                $user['email'],
                $user['password'],
                $user['role'],
                $user['created_at'],
                $user['updated_at'],
                $user['phone_number']
            );
        }, $users);
        return $users;
    }
}
