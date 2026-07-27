<?php

namespace Modules\Warehouse\Policies;

use App\Models\User;
use Modules\Warehouse\Models\Putaway;

class PutawayPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('putaway-view');
    }

    public function view(User $user, Putaway $putaway): bool
    {
        return $user->can('putaway-view');
    }

    public function create(User $user): bool
    {
        return $user->can('putaway-create');
    }

    public function update(User $user, Putaway $putaway): bool
    {
        return $user->can('putaway-create');
    }

    public function delete(User $user, Putaway $putaway): bool
    {
        return $user->can('putaway-create');
    }

    public function complete(User $user, Putaway $putaway): bool
    {
        return $user->can('putaway-create');
    }

    public function cancel(User $user, Putaway $putaway): bool
    {
        return $user->can('putaway-create');
    }
}

