<?php


namespace Core\Auth;

class User
{
    public function __construct(
        private int $id,
        private string $login,
        private string $email,
        private string $password,
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    /**
     * Get the value of login
     */
    public function login()
    {
        return $this->login;
    }



    /**
     * Get the value of email
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * Get the value of password
     */
    public function password()
    {
        return $this->password;
    }
}
