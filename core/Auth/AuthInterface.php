<?php


namespace Core\Auth;

interface AuthInterface
{

    public function logout();
    public function check();
    public function getUser(): ?User;
    public function table(): string;
    public function login_field_type(): string;
    public function password(): string;
    public function session_field(): string;
    public function attempt(string $username, string $password): bool;
    public function is_user_exist_with_value(string $table, string $value, string $field): bool;
    public function get_from_session(string $key);
    public function getRole(): ?Role;
    public function getRoleList(): array;
}
