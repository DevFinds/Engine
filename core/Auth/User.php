<?php


namespace Core\Auth;

class User
{
    public function __construct(
        private int $id,
        private string $username,
        private string $lastname,
        private string $login,
        private string $email,
        private string $password,
        private string $role,
        private string $avatar,
        private string $created_at,
        private string $updated_at,
        private string $phone_number
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

    public function username()
    {
        return $this->username;
    }

    public function lastname()
    {
        return $this->lastname;
    }

    public function role()
    {
        return $this->role;
    }

    public function avatar()
    {
        return $this->avatar;
    }

    public function phone_number()
    {
        return $this->phone_number;
    }
}
