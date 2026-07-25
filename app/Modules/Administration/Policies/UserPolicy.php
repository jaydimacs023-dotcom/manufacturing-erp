<?php

namespace Modules\Administration\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view-administration') || $user->can('user-view');
    }

    public function view(User $user, User $targetUser): bool
    {
        return $user->can('view-administration') || $user->can('user-view');
    }

    public function create(User $user): bool
    {
        return $user->can('user-create');
    }

    public function update(User $user, User $targetUser): bool
    {
        return $user->can('user-update');
    }

    public function delete(User $user, User $targetUser): bool
    {
        // Users cannot delete themselves
        if ($user->id === $targetUser->id) {
            return false;
        }
        return $user->can('user-delete');
    }
}

