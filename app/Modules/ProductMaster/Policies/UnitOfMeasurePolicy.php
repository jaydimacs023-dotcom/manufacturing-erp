<?php

namespace Modules\ProductMaster\Policies;

use App\Models\User;
use Modules\ProductMaster\Models\UnitOfMeasure;

class UnitOfMeasurePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('uom-view');
    }

    public function view(User $user, UnitOfMeasure $uom): bool
    {
        return $user->can('uom-view');
    }

    public function create(User $user): bool
    {
        return $user->can('uom-create');
    }

    public function update(User $user, UnitOfMeasure $uom): bool
    {
        return $user->can('uom-update');
    }

    public function delete(User $user, UnitOfMeasure $uom): bool
    {
        return $user->can('uom-delete');
    }
}

