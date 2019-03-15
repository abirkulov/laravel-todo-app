<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Permission;

class RoleManager
{
    /**
     * Gets a role by id.
     * 
     * @param int $id
     * @return Role
     */
    public function getById(int $id)
    {
        return Role::findOrFail($id);
    }

    /**
     * Gets a role by id with
     * permissions.
     * 
     * @param int $id
     * @return Role
     */
    public function getByIdWithPermissions(int $id)
    {
        return Role::with('permissions')->findOrFail($id);
    }

    /**
     * Gets a role by name.
     * 
     * @param string $name
     * @return Role
     */
    public function getByName(string $name)
    {
        return Role::where('name', $name)->firstOrFail();
    }

    /**
     * Gets a role by name with
     * permisisons.
     * 
     * @param string $name
     * @return Role
     */
    public function getByNameWithPermissions(string $name)
    {
        return Role::with('permissions')
            ->where('name', $name)->firstOrFail($name);
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
     * 
     * @return Role
     */
    public function getAll()
    {
        return Role::all();
    }

    /**
     * Gets all roles with
     * permissions.
     * 
     * @return Role
     */
    public function getAllWithPermissions()
    {
        return Role::with('permissions')->get();
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
        $role = Role::create(['name' => $name]);
        $permissions = Permission::find($permissions);
        $role->syncPermissions($permissions);
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
        $role = $this->getById($id);
        $permissions = Permission::find($permissions);
        $role->syncPermissions($permissions);
        $role->update(['name' => $name]);
    }
}