<?php

namespace Modules\Sales\Policies;

use App\Models\User;

class ShipmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('shipment-view');
    }

    public function view(User $user): bool
    {
        return $user->can('shipment-view');
    }

    public function create(User $user): bool
    {
        return $user->can('shipment-create');
    }
}

