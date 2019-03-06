<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Permission;

class RoleManager
{
    private $role;

    /**
     * Gets a role by id.
     * If $withPermissions = true, then a role
     * with permissions will be retrieved,
     * otherwise just a role.
     * 
     * @param int $id
     * @param bool $withPermissions
     * @return Role
     */
    public function getById(int $id, bool $withPermissions = false)
    {
        if($withPermissions) {
            return Role::with('permissions')->findOrFail($id);
        }

        return Role::findOrFail($id);
    }

    /**
     * Gets a role by name.
     * If $withPermissions = true, then a role
     * with permissions will be retrieved,
     * otherwise just a role.
     * 
     * @param string $name
     * @param bool $withPermissions
     * @return Role
     */
    public function getByName(string $name, $withPermissions = false)
    {
        if($withPermissions) {
            return Role::with('permissions')->where('name', $name)->firstOrFail($name);
        }

        return Role::where('name', $name)->firstOrFail();
    }

    /**
     * Gets all permissions
     */
    public function getAllPermissions()
    {
        return Permission::all();
    }

    /**
     * Gets all roles.
     * If $withPermissions = true, then all roles
     * with permissions will be retrieved,
     * otherwise just a role.
     */
    public function getAll(bool $withPermissions = false)
    {
        if($withPermissions) {
            return Role::with('permissions')->get();
        }

        return Role::all();
    }

    /**
     * Creates a new role with permissions.
     * 
     * @param string $name;
     * @param array $permissions
     * @return void
     */
    public function create(string $name, array $permissions)
    {
        $this->role = Role::create(['name' => $name]);
        $permissions = Permission::find($permissions);
        $this->role->syncPermissions($permissions);
    }

    /**
     * Updates a role with permissions.
     * 
     * @param int $id
     * @param string $name;
     * @param array $permissions
     * @return void
     */
    public function update(int $id, string $name, array $permissions)
    {
        $role = Role::with('permissions')->find($id);
        $role = $this->getById($id, true);

        $permissions = Permission::find($permissions);

        $role->syncPermissions($permissions);
        $role->update(['name' => $name]);
    }
}