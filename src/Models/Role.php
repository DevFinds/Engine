<?php


namespace Source\Models;

class Role
{
    public function __construct(
        private int $role_id,
        private string $role_name,
        private string $role_perm_level
    ) {
    }

    public function role_id()
    {
        return $this->role_id;
    }

    public function role_name()
    {

        return $this->role_name;
    }

    public function role_perm_level()
    {
        return $this->role_perm_level;
    }

    public function addNewRole()
    {
        var_dump($_SESSION);
    }
}
