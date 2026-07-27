<?php

namespace Modules\Procurement\Policies;

use App\Models\User;
use Modules\Procurement\Models\SupplierReturn;

class SupplierReturnPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('supplier-return-view');
    }

    public function view(User $user, SupplierReturn $supplierReturn): bool
    {
        return $user->can('supplier-return-view');
    }

    public function create(User $user): bool
    {
        return $user->can('supplier-return-create');
    }

    public function update(User $user, SupplierReturn $supplierReturn): bool
    {
        return $user->can('supplier-return-update');
    }

    public function delete(User $user, SupplierReturn $supplierReturn): bool
    {
        return $user->can('supplier-return-delete');
    }

    public function complete(User $user, SupplierReturn $supplierReturn): bool
    {
        return $user->can('supplier-return-complete');
    }

    public function cancel(User $user, SupplierReturn $supplierReturn): bool
    {
        return $user->can('supplier-return-cancel');
    }
}

