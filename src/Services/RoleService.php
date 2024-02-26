<?php


namespace Source\Services;

use Core\Database\DatabaseInterface;
use Source\Models\Role;

class RoleService
{
    public function __construct(
        private DatabaseInterface $db,
    ) {
    }

    public function getAllFromDB(): array
    {
        $roles = $this->db->get('roles');
        $roles = array_map(function ($role) {
            return new Role(
                $role['role_id'],
                $role['role_name'],
                $role['role_perm_level'],
            );
        }, $roles);
        return $roles;
    }

    public function getRoleById(int $id): ?array
    {
        $role = $this->db->first_found_in_db('roles', ['id' => $id]);
        return $role;
    }
}
