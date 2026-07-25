<?php

namespace Modules\Administration\Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleService
{
    public function getPaginated(int $perPage = 15)
    {
        return Role::orderBy('name')->paginate($perPage);
    }

    public function findById(int $id): ?Role
    {
        return Role::findById($id);
    }

    public function create(array $data, array $permissions = []): Role
    {
        $role = Role::create(['name' => $data['name'], 'guard_name' => 'web']);
        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }
        return $role;
    }

    public function update(Role $role, array $data, array $permissions = []): bool
    {
        $role->update(['name' => $data['name']]);
        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }
        return true;
    }

    public function delete(Role $role): bool
    {
        return $role->delete();
    }

    public function getAllRoles()
    {
        return Role::all();
    }

    public function getAllPermissions()
    {
        return Permission::orderBy('name')->get();
    }

    public function getGroupedPermissions(): array
    {
        $permissions = Permission::orderBy('name')->get();
        $grouped = [];

        foreach ($permissions as $permission) {
            $parts = explode('-', $permission->name);
            $group = $parts[0] ?? 'general';
            $action = $parts[1] ?? $permission->name;

            if (!isset($grouped[$group])) {
                $grouped[$group] = [];
            }
            $grouped[$group][] = $permission;
        }

        return $grouped;
    }
}

