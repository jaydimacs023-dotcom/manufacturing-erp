<?php

namespace Modules\Procurement\Repositories;

use App\Repositories\BaseRepository;
use Modules\Procurement\Models\PurchaseRequestItem;

class PurchaseRequestItemRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return PurchaseRequestItem::class;
    }

    public function findByPurchaseRequest(int $purchaseRequestId)
    {
        return $this->model->where('purchase_request_id', $purchaseRequestId)->get();
    }
}

