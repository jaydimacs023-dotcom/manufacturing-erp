<?php

namespace Modules\ProductMaster\Policies;

use App\Models\User;
use Modules\ProductMaster\Models\Product;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('product-view');
    }

    public function view(User $user, Product $product): bool
    {
        return $user->can('product-view');
    }

    public function create(User $user): bool
    {
        return $user->can('product-create');
    }

    public function update(User $user, Product $product): bool
    {
        return $user->can('product-update');
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->can('product-delete');
    }
}

