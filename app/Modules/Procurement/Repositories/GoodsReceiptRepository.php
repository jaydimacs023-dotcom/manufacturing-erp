<?php

namespace Modules\Procurement\Repositories;

use App\Repositories\BaseRepository;
use Modules\Procurement\Models\GoodsReceipt;

class GoodsReceiptRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return GoodsReceipt::class;
    }

    public function findByPurchaseOrder(int $purchaseOrderId)
    {
        return $this->model->where('purchase_order_id', $purchaseOrderId)->get();
    }

    public function findByWarehouse(int $warehouseId)
    {
        return $this->model->where('warehouse_id', $warehouseId)->get();
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)->get();
    }
}

