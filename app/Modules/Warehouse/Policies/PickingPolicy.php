<?php

namespace Modules\Warehouse\Policies;

use App\Models\User;
use Modules\Warehouse\Models\Picking;

class PickingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('picking-view');
    }

    public function view(User $user, Picking $picking): bool
    {
        return $user->can('picking-view');
    }

    public function create(User $user): bool
    {
        return $user->can('picking-create');
    }

    public function update(User $user, Picking $picking): bool
    {
        return $user->can('picking-create');
    }

    public function delete(User $user, Picking $picking): bool
    {
        return $user->can('picking-create');
    }

    public function complete(User $user, Picking $picking): bool
    {
        return $user->can('picking-create');
    }

    public function cancel(User $user, Picking $picking): bool
    {
        return $user->can('picking-create');
    }
}

