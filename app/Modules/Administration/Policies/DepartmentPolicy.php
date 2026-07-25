<?php

namespace Modules\Administration\Policies;

use App\Models\User;
use Modules\Administration\Models\Department;

class DepartmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view-administration') || $user->can('department-view');
    }

    public function view(User $user, Department $department): bool
    {
        return $user->can('view-administration') || $user->can('department-view');
    }

    public function create(User $user): bool
    {
        return $user->can('department-create');
    }

    public function update(User $user, Department $department): bool
    {
        return $user->can('department-update');
    }

    public function delete(User $user, Department $department): bool
    {
        return $user->can('department-delete');
    }
}

