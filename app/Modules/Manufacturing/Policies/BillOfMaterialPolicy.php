<?php

namespace Modules\Manufacturing\Policies;

use App\Models\User;
use Modules\Manufacturing\Models\BillOfMaterial;

class BillOfMaterialPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('bom-view');
    }

    public function view(User $user, BillOfMaterial $billOfMaterial): bool
    {
        return $user->can('bom-view');
    }

    public function create(User $user): bool
    {
        return $user->can('bom-create');
    }

    public function update(User $user, BillOfMaterial $billOfMaterial): bool
    {
        return $user->can('bom-update');
    }

    public function delete(User $user, BillOfMaterial $billOfMaterial): bool
    {
        return $user->can('bom-delete');
    }

    public function approve(User $user, BillOfMaterial $billOfMaterial): bool
    {
        return $user->can('bom-update');
    }
}
