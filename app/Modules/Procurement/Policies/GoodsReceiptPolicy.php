<?php

namespace Modules\Procurement\Policies;

use App\Models\User;
use Modules\Procurement\Models\GoodsReceipt;

class GoodsReceiptPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('goods-receipt-view');
    }

    public function view(User $user, GoodsReceipt $goodsReceipt): bool
    {
        return $user->can('goods-receipt-view');
    }

    public function create(User $user): bool
    {
        return $user->can('goods-receipt-create');
    }

    public function update(User $user, GoodsReceipt $goodsReceipt): bool
    {
        return $user->can('goods-receipt-update');
    }

    public function delete(User $user, GoodsReceipt $goodsReceipt): bool
    {
        return $user->can('goods-receipt-delete');
    }

    public function complete(User $user, GoodsReceipt $goodsReceipt): bool
    {
        return $user->can('goods-receipt-complete');
    }

    public function cancel(User $user, GoodsReceipt $goodsReceipt): bool
    {
        return $user->can('goods-receipt-cancel');
    }
}

