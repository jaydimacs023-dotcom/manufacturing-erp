<?php

namespace Modules\Inventory\Repositories;

use App\Repositories\BaseRepository;
use Modules\Inventory\Models\StockCard;

class StockCardRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return StockCard::class;
    }

    public function findByProduct(int $productId)
    {
        return $this->model->where('product_id', $productId)->get();
    }

    public function findByWarehouse(int $warehouseId)
    {
        return $this->model->where('warehouse_id', $warehouseId)->get();
    }

    public function findCard(int $productId, int $warehouseId, ?string $batchNumber = null): ?StockCard
    {
        $query = $this->model->where('product_id', $productId)
            ->where('warehouse_id', $warehouseId);
        if ($batchNumber) {
            $query->where('batch_number', $batchNumber);
        } else {
            $query->whereNull('batch_number');
        }
        return $query->first();
    }

    public function getLowStock(int $threshold = 10)
    {
        return $this->model->where('quantity_available', '<=', $threshold)
            ->where('quantity_available', '>', 0)
            ->orderBy('quantity_available', 'asc')
            ->get();
    }

    public function getOutOfStock()
    {
        return $this->model->where('quantity_available', '<=', 0)->get();
    }

    public function getExpiring($days = 30)
    {
        return $this->model->whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays($days))
            ->where('expiry_date', '>=', now())
            ->where('quantity_on_hand', '>', 0)
            ->get();
    }
}

