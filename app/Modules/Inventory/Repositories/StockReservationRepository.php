<?php

namespace Modules\Inventory\Repositories;

use App\Repositories\BaseRepository;
use Modules\Inventory\Models\StockReservation;

class StockReservationRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return StockReservation::class;
    }

    public function findActiveByProduct(int $productId, int $warehouseId)
    {
        return $this->model->where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->where('status', 'active')
            ->get();
    }

    public function findByReference(string $referenceType, int $referenceId)
    {
        return $this->model->where('reference_type', $referenceType)
            ->where('reference_id', $referenceId)
            ->get();
    }
}

