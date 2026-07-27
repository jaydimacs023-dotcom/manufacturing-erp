<?php

namespace Modules\Procurement\Policies;

use App\Models\User;
use Modules\Procurement\Models\PurchaseOrder;

class PurchaseOrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('purchase-order-view');
    }

    public function view(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->can('purchase-order-view');
    }

    public function create(User $user): bool
    {
        return $user->can('purchase-order-create');
    }

    public function update(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->can('purchase-order-update');
    }

    public function delete(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->can('purchase-order-delete');
    }

    public function approve(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->can('purchase-order-approve');
    }

    public function cancel(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->can('purchase-order-cancel');
    }

    public function close(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->can('purchase-order-close');
    }

    public function send(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->can('purchase-order-send');
    }
}

