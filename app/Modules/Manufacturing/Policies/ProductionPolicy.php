<?php

namespace Modules\Manufacturing\Policies;

use App\Models\User;

class ProductionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manufacturing-order-view');
    }

    public function issueMaterials(User $user): bool
    {
        return $user->can('manufacturing-order-start');
    }

    public function recordOutput(User $user): bool
    {
        return $user->can('manufacturing-order-complete');
    }

    public function approveQc(User $user): bool
    {
        return $user->can('inspection-approve');
    }
}
