<?php


namespace Core\Auth;

use Core\Auth\AuthInterface;
use Core\Database\DatabaseInterface;
use Core\Session\SessionInterface;

class Auth implements AuthInterface
{
    public function __construct(
        private DatabaseInterface $database,
        private SessionInterface $session,

    ) {
    }

    public function login($login, $password)
    {

        

    }
    public function logout()
    {
    }
    public function chek_authorization()
    {
    }
    public function getUser(): ?array
    {
        return [];
    }
}
