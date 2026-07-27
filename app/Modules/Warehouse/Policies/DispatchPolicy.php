<?php

namespace Modules\Warehouse\Policies;

use App\Models\User;
use Modules\Warehouse\Models\Dispatch;

class DispatchPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('dispatch-view');
    }

    public function view(User $user, Dispatch $dispatch): bool
    {
        return $user->can('dispatch-view');
    }

    public function create(User $user): bool
    {
        return $user->can('dispatch-create');
    }

    public function update(User $user, Dispatch $dispatch): bool
    {
        return $user->can('dispatch-create');
    }

    public function delete(User $user, Dispatch $dispatch): bool
    {
        return $user->can('dispatch-create');
    }

    public function pack(User $user, Dispatch $dispatch): bool
    {
        return $user->can('packing-create');
    }

    public function load(User $user, Dispatch $dispatch): bool
    {
        return $user->can('dispatch-create');
    }

    public function dispatch(User $user, Dispatch $dispatch): bool
    {
        return $user->can('dispatch-create');
    }

    public function cancel(User $user, Dispatch $dispatch): bool
    {
        return $user->can('dispatch-create');
    }
}

