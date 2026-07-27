<?php

namespace Modules\Warehouse\Policies;

use App\Models\User;
use Modules\Warehouse\Models\WarehouseTransfer;

class WarehouseTransferPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('inventory-transfer');
    }

    public function view(User $user, WarehouseTransfer $transfer): bool
    {
        return $user->can('inventory-transfer');
    }

    public function create(User $user): bool
    {
        return $user->can('inventory-transfer');
    }

    public function update(User $user, WarehouseTransfer $transfer): bool
    {
        return $user->can('inventory-transfer');
    }

    public function delete(User $user, WarehouseTransfer $transfer): bool
    {
        return $user->can('inventory-transfer');
    }

    public function approve(User $user, WarehouseTransfer $transfer): bool
    {
        return $user->can('inventory-transfer');
    }

    public function complete(User $user, WarehouseTransfer $transfer): bool
    {
        return $user->can('inventory-transfer');
    }

    public function cancel(User $user, WarehouseTransfer $transfer): bool
    {
        return $user->can('inventory-transfer');
    }
}

