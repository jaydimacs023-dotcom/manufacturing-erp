<?php

namespace Modules\Inventory\Policies;

use App\Models\User;
use Modules\Inventory\Models\InventoryTransfer;

class InventoryTransferPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('inventory-view');
    }

    public function view(User $user, InventoryTransfer $inventoryTransfer): bool
    {
        return $user->can('inventory-view');
    }

    public function create(User $user): bool
    {
        return $user->can('inventory-transfer');
    }

    public function update(User $user, InventoryTransfer $inventoryTransfer): bool
    {
        return $user->can('inventory-transfer');
    }

    public function delete(User $user, InventoryTransfer $inventoryTransfer): bool
    {
        return $user->can('inventory-transfer');
    }

    public function complete(User $user, InventoryTransfer $inventoryTransfer): bool
    {
        return $user->can('inventory-transfer');
    }

    public function cancel(User $user, InventoryTransfer $inventoryTransfer): bool
    {
        return $user->can('inventory-transfer');
    }
}
