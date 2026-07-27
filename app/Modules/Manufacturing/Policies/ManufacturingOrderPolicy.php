<?php

namespace Modules\Manufacturing\Policies;

use App\Models\User;
use Modules\Manufacturing\Models\ManufacturingOrder;

class ManufacturingOrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manufacturing-order-view');
    }

    public function view(User $user, ManufacturingOrder $manufacturingOrder): bool
    {
        return $user->can('manufacturing-order-view');
    }

    public function create(User $user): bool
    {
        return $user->can('manufacturing-order-create');
    }

    public function update(User $user, ManufacturingOrder $manufacturingOrder): bool
    {
        return $user->can('manufacturing-order-update');
    }

    public function delete(User $user, ManufacturingOrder $manufacturingOrder): bool
    {
        return $user->can('manufacturing-order-cancel');
    }

    public function start(User $user, ManufacturingOrder $manufacturingOrder): bool
    {
        return $user->can('manufacturing-order-start');
    }

    public function complete(User $user, ManufacturingOrder $manufacturingOrder): bool
    {
        return $user->can('manufacturing-order-complete');
    }

    public function cancel(User $user, ManufacturingOrder $manufacturingOrder): bool
    {
        return $user->can('manufacturing-order-cancel');
    }
}
