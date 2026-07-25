<?php

namespace Modules\ProductMaster\Policies;

use App\Models\User;
use Modules\ProductMaster\Models\ProductCategory;

class ProductCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('product-category-view');
    }

    public function view(User $user, ProductCategory $category): bool
    {
        return $user->can('product-category-view');
    }

    public function create(User $user): bool
    {
        return $user->can('product-category-create');
    }

    public function update(User $user, ProductCategory $category): bool
    {
        return $user->can('product-category-update');
    }

    public function delete(User $user, ProductCategory $category): bool
    {
        return $user->can('product-category-delete');
    }
}

