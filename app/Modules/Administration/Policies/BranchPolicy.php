<?php

namespace Modules\Administration\Policies;

use App\Models\User;
use Modules\Administration\Models\Branch;

class BranchPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view-administration') || $user->can('branch-view');
    }

    public function view(User $user, Branch $branch): bool
    {
        return $user->can('view-administration') || $user->can('branch-view');
    }

    public function create(User $user): bool
    {
        return $user->can('branch-create');
    }

    public function update(User $user, Branch $branch): bool
    {
        return $user->can('branch-update');
    }

    public function delete(User $user, Branch $branch): bool
    {
        return $user->can('branch-delete');
    }
}

