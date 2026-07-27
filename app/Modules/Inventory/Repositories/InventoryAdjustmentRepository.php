<?php

namespace Modules\Inventory\Repositories;

use App\Repositories\BaseRepository;
use Modules\Inventory\Models\InventoryAdjustment;

class InventoryAdjustmentRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return InventoryAdjustment::class;
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)->orderBy('created_at', 'desc')->get();
    }

    public function findByWarehouse(int $warehouseId)
    {
        return $this->model->where('warehouse_id', $warehouseId)->orderBy('created_at', 'desc')->get();
    }

    public function findPendingApproval()
    {
        return $this->model->where('status', 'pending_approval')->orderBy('created_at', 'asc')->get();
    }
}

