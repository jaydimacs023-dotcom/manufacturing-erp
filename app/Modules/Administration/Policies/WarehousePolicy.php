<?php

namespace Modules\Administration\Policies;

use App\Models\User;
use Modules\Administration\Models\Warehouse;

class WarehousePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view-administration') || $user->can('warehouse-view');
    }

    public function view(User $user, Warehouse $warehouse): bool
    {
        return $user->can('view-administration') || $user->can('warehouse-view');
    }

    public function create(User $user): bool
    {
        return $user->can('warehouse-create');
    }

    public function update(User $user, Warehouse $warehouse): bool
    {
        return $user->can('warehouse-update');
    }

    public function delete(User $user, Warehouse $warehouse): bool
    {
        return $user->can('warehouse-delete');
    }
}

