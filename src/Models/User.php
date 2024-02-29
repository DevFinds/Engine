<?php


namespace Source\Models;

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
        private string $created_at,
        private string $updated_at,
        private string $phone_number
    ) {
    }

    public function id()
    {
        return $this->id;
    }

    public function username()
    {
        return $this->username;
    }

    public function lastname()
    {
        return $this->lastname;
    }

    public function login()
    {
        return $this->login;
    }

    public function email()
    {
        return $this->email;
    }

    public function password()
    {
        return $this->password;
    }

    public function role()
    {
        return $this->role;
    }

    public function created_at()
    {
        return $this->created_at;
    }

    public function updated_at()
    {
        return $this->updated_at;
    }

    public function phone_number()
    {
        return $this->phone_number;
    }
}
