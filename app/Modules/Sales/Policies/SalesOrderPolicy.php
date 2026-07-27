<?php

namespace Modules\Sales\Policies;

use App\Models\User;
use Modules\Sales\Models\SalesOrder;

class SalesOrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('sales-order-view');
    }

    public function view(User $user, SalesOrder $salesOrder): bool
    {
        return $user->can('sales-order-view');
    }

    public function create(User $user): bool
    {
        return $user->can('sales-order-create');
    }

    public function update(User $user, SalesOrder $salesOrder): bool
    {
        return $user->can('sales-order-update');
    }

    public function delete(User $user, SalesOrder $salesOrder): bool
    {
        return $user->can('sales-order-delete');
    }

    public function approve(User $user, SalesOrder $salesOrder): bool
    {
        return $user->can('sales-order-approve');
    }

    public function submit(User $user, SalesOrder $salesOrder): bool
    {
        return $user->can('sales-order-create');
    }

    public function cancel(User $user, SalesOrder $salesOrder): bool
    {
        return $user->can('sales-order-create');
    }
}

