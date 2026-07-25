<?php

namespace Modules\ProductMaster\Policies;

use App\Models\User;
use Modules\ProductMaster\Models\ProductSpecification;

class ProductSpecificationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('product-view');
    }

    public function view(User $user, ProductSpecification $spec): bool
    {
        return $user->can('product-view');
    }

    public function create(User $user): bool
    {
        return $user->can('product-update');
    }

    public function update(User $user, ProductSpecification $spec): bool
    {
        return $user->can('product-update');
    }

    public function delete(User $user, ProductSpecification $spec): bool
    {
        return $user->can('product-update');
    }
}

