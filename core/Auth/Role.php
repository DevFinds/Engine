<?php


namespace Core\Auth;

class Role
{
    public function __construct(
        private string $role_id,
        private string $role_name,
        private string $role_perm_level
    ) {}

    public function id()
    {
        return $this->role_id;
    }

    public function name()
    {
        return $this->role_name;
    }

    public function perm_level()
    {
        return $this->role_perm_level;
    }
}
