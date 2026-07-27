<?php

namespace Modules\Procurement\Repositories;

use App\Repositories\BaseRepository;
use Modules\Procurement\Models\PurchaseOrderItem;

class PurchaseOrderItemRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return PurchaseOrderItem::class;
    }

    public function findByPurchaseOrder(int $purchaseOrderId)
    {
        return $this->model->where('purchase_order_id', $purchaseOrderId)->get();
    }
}

