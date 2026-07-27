<?php

namespace Modules\Inventory\Repositories;

use App\Repositories\BaseRepository;
use Modules\Inventory\Models\InventoryMovement;

class InventoryMovementRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return InventoryMovement::class;
    }

    public function findByProduct(int $productId)
    {
        return $this->model->where('product_id', $productId)->orderBy('created_at', 'desc')->get();
    }

    public function findByWarehouse(int $warehouseId)
    {
        return $this->model->where('warehouse_id', $warehouseId)->orderBy('created_at', 'desc')->get();
    }

    public function findByType(string $movementType)
    {
        return $this->model->where('movement_type', $movementType)->orderBy('created_at', 'desc')->get();
    }

    public function findByReference(string $referenceType, int $referenceId)
    {
        return $this->model->where('reference_type', $referenceType)
            ->where('reference_id', $referenceId)
            ->get();
    }

    public function getStockCardData(int $productId, ?int $warehouseId = null)
    {
        $query = $this->model->where('product_id', $productId);
        if ($warehouseId) {
            $query->where('warehouse_id', $warehouseId);
        }
        return $query->orderBy('created_at', 'asc')->get();
    }
}

