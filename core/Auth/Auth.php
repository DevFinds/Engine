<?php


namespace Core\Auth;

use Core\Auth\AuthInterface;
use Core\Config\ConfigInterface;
use Core\Database\DatabaseInterface;
use Core\Session\SessionInterface;

class Auth implements AuthInterface
{
    public function __construct(
        private DatabaseInterface $database,
        private SessionInterface $session,
        private ConfigInterface $config,

    ) {
    }

    public function logout()
    {
        $this->session->remove($this->session_field());
    }
    public function check()
    {
        return $this->session->has($this->session_field());
    }
    public function getUser(): ?User
    {
        if (!$this->check()) {
            return null;
        }

        $user = $this->database->first_found_in_db($this->table(), [
            'id' => $this->session->get($this->session_field())
        ]);

        if ($user) {
            return new User(
                $user['id'],
                $user['username'],
                $user['lastname'],
                $user[$this->login_field_type()],
                $user['email'],
                $user[$this->password()],
                $user['role'],
                $user['avatar'],
                $user['created_at'],
                $user['updated_at'],
                $user['phone_number']
            );
        }


        return null;
    }

    public function is_user_exist_with_value(string $table, string $value, string $field): bool
    {
        $user = $this->database->first_found_in_db($table, [
            $field => $value
        ]);
        if ($user !== null) {
            return true;
        }
        return false;
    }

    public function attempt(string $login, string $password): bool
    {
        $user = $this->database->first_found_in_db($this->table(), [
            $this->login_field_type() => $login

        ]);

        if (!$user) {
            return false;
        }
        if (!password_verify($password, $user[$this->password()])) {
            return false;
        }

        $this->session->set($this->session_field(), $user['id']);
        return true;
    }

    public function table(): string
    {
        return $this->config->getJson('auth.table', 'users');
    }

    public function login_field_type(): string
    {
        return $this->config->getJson('auth.login_field_type', 'login');
    }

    public function password(): string
    {
        return $this->config->getJson('auth.password', 'password');
    }

    public function session_field(): string
    {
        return $this->config->getJson('auth.session_field', 'user_id');
    }
}
