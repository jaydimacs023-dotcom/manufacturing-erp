<?php

namespace Modules\Inventory\Policies;

use App\Models\User;
use Modules\Inventory\Models\InventoryAdjustment;

class InventoryAdjustmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('inventory-view');
    }

    public function view(User $user, InventoryAdjustment $inventoryAdjustment): bool
    {
        return $user->can('inventory-view');
    }

    public function create(User $user): bool
    {
        return $user->can('inventory-adjust');
    }

    public function update(User $user, InventoryAdjustment $inventoryAdjustment): bool
    {
        return $user->can('inventory-adjust');
    }

    public function delete(User $user, InventoryAdjustment $inventoryAdjustment): bool
    {
        return $user->can('inventory-adjust');
    }

    public function submit(User $user, InventoryAdjustment $inventoryAdjustment): bool
    {
        return $user->can('inventory-adjust');
    }

    public function approve(User $user, InventoryAdjustment $inventoryAdjustment): bool
    {
        return $user->can('inventory-adjust');
    }

    public function reject(User $user, InventoryAdjustment $inventoryAdjustment): bool
    {
        return $user->can('inventory-adjust');
    }

    public function cancel(User $user, InventoryAdjustment $inventoryAdjustment): bool
    {
        return $user->can('inventory-adjust');
    }
}
