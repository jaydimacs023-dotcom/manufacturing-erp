<?php

namespace Modules\Inventory\Repositories;

use App\Repositories\BaseRepository;
use Modules\Inventory\Models\InventoryAdjustmentItem;

class InventoryAdjustmentItemRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return InventoryAdjustmentItem::class;
    }

    public function findByAdjustment(int $adjustmentId)
    {
        return $this->model->where('inventory_adjustment_id', $adjustmentId)->get();
    }
}

