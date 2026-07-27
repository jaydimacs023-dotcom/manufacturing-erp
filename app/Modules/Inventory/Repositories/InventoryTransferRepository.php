<?php

namespace Modules\Inventory\Repositories;

use App\Repositories\BaseRepository;
use Modules\Inventory\Models\InventoryTransfer;

class InventoryTransferRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return InventoryTransfer::class;
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)->orderBy('created_at', 'desc')->get();
    }

    public function findByFromWarehouse(int $warehouseId)
    {
        return $this->model->where('from_warehouse_id', $warehouseId)->orderBy('created_at', 'desc')->get();
    }

    public function findByToWarehouse(int $warehouseId)
    {
        return $this->model->where('to_warehouse_id', $warehouseId)->orderBy('created_at', 'desc')->get();
    }
}

