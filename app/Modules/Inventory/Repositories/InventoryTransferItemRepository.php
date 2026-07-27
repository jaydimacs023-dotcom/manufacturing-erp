<?php

namespace Modules\Inventory\Repositories;

use App\Repositories\BaseRepository;
use Modules\Inventory\Models\InventoryTransferItem;

class InventoryTransferItemRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return InventoryTransferItem::class;
    }

    public function findByTransfer(int $transferId)
    {
        return $this->model->where('inventory_transfer_id', $transferId)->get();
    }
}

