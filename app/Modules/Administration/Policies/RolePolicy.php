<?php

namespace Modules\Administration\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view-administration') || $user->can('role-view');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->can('view-administration') || $user->can('role-view');
    }

    public function create(User $user): bool
    {
        return $user->can('role-create');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->can('role-update');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->can('role-delete');
    }
}

