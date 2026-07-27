<?php

namespace Modules\Procurement\Policies;

use App\Models\User;
use Modules\Procurement\Models\PurchaseRequest;

class PurchaseRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('purchase-request-view');
    }

    public function view(User $user, PurchaseRequest $purchaseRequest): bool
    {
        return $user->can('purchase-request-view');
    }

    public function create(User $user): bool
    {
        return $user->can('purchase-request-create');
    }

    public function update(User $user, PurchaseRequest $purchaseRequest): bool
    {
        return $user->can('purchase-request-update');
    }

    public function delete(User $user, PurchaseRequest $purchaseRequest): bool
    {
        return $user->can('purchase-request-delete');
    }

    public function approve(User $user, PurchaseRequest $purchaseRequest): bool
    {
        return $user->can('purchase-request-approve');
    }

    public function reject(User $user, PurchaseRequest $purchaseRequest): bool
    {
        return $user->can('purchase-request-reject');
    }

    public function submit(User $user, PurchaseRequest $purchaseRequest): bool
    {
        return $user->can('purchase-request-submit');
    }

    public function cancel(User $user, PurchaseRequest $purchaseRequest): bool
    {
        return $user->can('purchase-request-cancel');
    }
}

