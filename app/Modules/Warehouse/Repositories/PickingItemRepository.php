<?php

namespace Modules\Warehouse\Repositories;

use App\Repositories\BaseRepository;
use Modules\Warehouse\Models\PickingItem;

class PickingItemRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return PickingItem::class;
    }

    public function findByPicking(int $pickingId)
    {
        return $this->model->where('picking_id', $pickingId)
            ->with('product', 'storageLocation')
            ->get();
    }
}

