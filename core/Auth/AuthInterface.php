<?php


namespace Core\Auth;

interface AuthInterface
{
    public function login($login, $password);
    public function logout();
    public function chek_authorization();
    public function getUser(): ?array;
}
